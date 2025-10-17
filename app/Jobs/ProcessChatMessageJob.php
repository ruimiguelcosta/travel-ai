<?php

namespace App\Jobs;

use App\Domain\Chat\Services\ChatSessionService;
use App\Domain\LLM\Services\LLMService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessChatMessageJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private string $message,
        private string $sessionId,
        private string $language = 'pt',
        private string $driver = 'chatgpt',
    ) {}

    public function handle(LLMService $llmService): void
    {
        $sessionService = app(\App\Domain\Chat\Services\ChatSessionService::class);
        $templateService = app(\App\Domain\Chat\Services\TravelTemplateService::class);
        $contextService = app(\App\Domain\Chat\Services\ChatContextService::class);

        try {
            // Detectar idioma da mensagem do utilizador
            $detectedLanguage = $contextService->detectAndUpdateLanguage($this->sessionId, $this->message);

            // Usar o idioma detectado se disponível, senão usar o idioma da sessão
            $responseLanguage = $detectedLanguage ?: $this->language;

            // Guardar mensagem do utilizador na base de dados
            $sessionService->addMessage(
                $this->sessionId,
                'user',
                $this->message,
                $responseLanguage
            );

            // Tentar extrair dados de viagem da mensagem
            $extractedData = $templateService->extractTravelDataFromMessage($this->message);

            // Se extraiu dados, guardar na sessão
            if (! empty($extractedData)) {
                $sessionService->updateSessionData($this->sessionId, $extractedData);
            }

            $prompt = $this->buildChatPrompt($this->message, $responseLanguage, $sessionService, $extractedData);

            $response = $llmService->generateResponse(
                $prompt,
                $this->driver,
                [
                    'language' => $responseLanguage,
                    'session_id' => $this->sessionId,
                ]
            );

            // Guardar resposta do bot na base de dados
            $sessionService->addMessage(
                $this->sessionId,
                'bot',
                $response->content,
                $responseLanguage,
                $response->metadata
            );

            $this->broadcastResponse($response->content);

            Log::info('Chat message processed and stored in database', [
                'session_id' => $this->sessionId,
                'original_language' => $this->language,
                'detected_language' => $detectedLanguage,
                'response_language' => $responseLanguage,
                'driver' => $this->driver,
                'extracted_data' => $extractedData,
            ]);
        } catch (\Exception $e) {
            Log::error('Chat message processing failed', [
                'session_id' => $this->sessionId,
                'language' => $this->language,
                'driver' => $this->driver,
                'error' => $e->getMessage(),
            ]);

            $errorMessage = match ($this->language) {
                'pt' => 'Desculpe, ocorreu um erro ao processar sua mensagem. Tente novamente.',
                'en' => 'Sorry, an error occurred while processing your message. Please try again.',
                'es' => 'Lo siento, ocurrió un error al procesar tu mensaje. Inténtalo de nuevo.',
                default => 'Sorry, an error occurred while processing your message. Please try again.',
            };

            // Guardar mensagem de erro na base de dados
            $sessionService->addMessage(
                $this->sessionId,
                'bot',
                $errorMessage,
                $this->language,
                ['error' => $e->getMessage()]
            );

            $this->broadcastResponse($errorMessage);
        }
    }

    private function buildChatPrompt(string $message, string $language, ChatSessionService $sessionService, array $extractedData = []): string
    {
        $systemPrompt = $this->getSystemPrompt($language);

        // Obter histórico da conversa
        $conversationHistory = $this->getConversationHistory($sessionService);

        // Obter dados da sessão
        $sessionData = $sessionService->getSessionData($this->sessionId);
        $allData = array_merge($sessionData, $extractedData);

        // Construir prompt com contexto
        $prompt = $systemPrompt;

        // Adicionar dados extraídos se existirem
        if (! empty($allData)) {
            $prompt .= "\n\nDados de viagem já recolhidos:\n";
            foreach ($allData as $field => $value) {
                if (! empty($value)) {
                    $fieldLabel = $this->getFieldLabel($field, $language);
                    $prompt .= "- {$fieldLabel}: {$value}\n";
                }
            }
        }

        if (! empty($conversationHistory)) {
            $prompt .= "\n\nHistórico da conversa:\n";
            foreach ($conversationHistory as $msg) {
                $role = $msg['type'] === 'user' ? 'Utilizador' : 'Assistente';
                $prompt .= "{$role}: {$msg['message']}\n";
            }
        }

        $prompt .= "\n\nMensagem atual do utilizador: {$message}";

        return $prompt;
    }

    private function getFieldLabel(string $field, string $language): string
    {
        $labels = [
            'pt' => [
                'full_name' => 'Nome completo',
                'email' => 'Email',
                'mobile_phone' => 'Telefone móvel',
                'city_from' => 'Cidade de origem',
                'city_destination' => 'Cidade de destino',
                'checkin_datetime' => 'Data e hora de check-in',
                'checkout_datetime' => 'Data e hora de check-out',
                'adults' => 'Número de adultos',
                'children' => 'Número de crianças',
                'need_car' => 'Precisa de carro',
            ],
            'en' => [
                'full_name' => 'Full name',
                'email' => 'Email',
                'mobile_phone' => 'Mobile phone',
                'city_from' => 'Departure city',
                'city_destination' => 'Destination city',
                'checkin_datetime' => 'Check-in date and time',
                'checkout_datetime' => 'Check-out date and time',
                'adults' => 'Number of adults',
                'children' => 'Number of children',
                'need_car' => 'Need car rental',
            ],
        ];

        return $labels[$language][$field] ?? $labels['pt'][$field] ?? $field;
    }

    private function getConversationHistory(ChatSessionService $sessionService): array
    {
        $messages = $sessionService->getSessionMessages($this->sessionId);

        // Retornar apenas as últimas 10 mensagens para não sobrecarregar o prompt
        return $messages->take(-10)->map(function ($msg) {
            return [
                'type' => $msg->type,
                'message' => $msg->message,
                'sent_at' => $msg->sent_at,
            ];
        })->toArray();
    }

    private function getSystemPrompt(string $language): string
    {
        return match ($language) {
            'pt' => 'Você é um assistente AI especializado em turismo e viagens. 
                    Responda sempre em português de forma clara e direta.
                    
                    IMPORTANTE: Se o utilizador fornecer informações de viagem na primeira mensagem (como "preciso de preparar uma viagem para 2 pessoas, de rio de janeiro para são paulo"), reconheça e confirme esses dados extraídos automaticamente. Não peça novamente informações que já foram fornecidas.
                    
                    Seja útil e forneça informações práticas sobre destinos, hotéis, atividades e orçamentos.
                    Colete apenas as informações que ainda não foram fornecidas.',
            'es' => 'Eres un asistente AI especializado en turismo y viajes.
                    Responde siempre en español de forma clara y directa.
                    Sé útil y proporciona información práctica sobre destinos, hoteles, actividades y presupuestos.',
            'fr' => 'Vous êtes un assistant AI spécialisé dans le tourisme et les voyages.
                    Répondez toujours en français de manière claire et directe.
                    Soyez utile et fournissez des informations pratiques sur les destinations, hôtels, activités et budgets.',
            'de' => 'Sie sind ein AI-Assistent, der auf Tourismus und Reisen spezialisiert ist.
                    Antworten Sie immer auf Deutsch klar und direkt.
                    Seien Sie hilfreich und liefern Sie praktische Informationen über Reiseziele, Hotels, Aktivitäten und Budgets.',
            'it' => 'Sei un assistente AI specializzato in turismo e viaggi.
                    Rispondi sempre in italiano in modo chiaro e diretto.
                    Sii utile e fornisci informazioni pratiche su destinazioni, hotel, attività e budget.',
            default => 'You are an AI assistant specialized in travel and tourism.
                       Always respond in English in a clear and direct way.
                       
                       IMPORTANT: If the user provides travel information in the first message (like "I need to prepare a trip for 2 people, from rio de janeiro to são paulo"), recognize and confirm those automatically extracted data. Do not ask again for information that has already been provided.
                       
                       Be helpful and provide practical information about destinations, hotels, activities and budgets.
                       Collect only the information that has not yet been provided.',
        };
    }

    private function broadcastResponse(string $response): void
    {
        // Por enquanto, vamos usar uma abordagem simples
        // Em produção, você pode usar Laravel Broadcasting (Pusher, Redis, etc.)
        // Para este exemplo, vamos armazenar a resposta em cache para ser recuperada pelo frontend

        $cacheKey = "chat_response_{$this->sessionId}";
        cache()->put($cacheKey, [
            'message' => $response,
            'timestamp' => now()->toISOString(),
            'language' => $this->language,
        ], 300); // 5 minutos
    }
}
