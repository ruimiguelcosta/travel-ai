<?php

namespace App\Domain\Chat\Services;

use App\Domain\Chat\Data\ChatMessageData;
use App\Domain\Chat\Data\ChatResponseData;
use App\Domain\LLM\Services\LLMService;
use Illuminate\Support\Facades\Log;

class ChatService
{
    public function __construct(
        private ChatGreetingService $greetingService,
        private LLMService $llmService,
    ) {}

    public function initializeChat(?string $browserLanguage = null): ChatResponseData
    {
        $greeting = $this->greetingService->generateGreeting($browserLanguage);
        $sessionId = $this->generateSessionId();

        return new ChatResponseData(
            message: $greeting['full_message'],
            language: $greeting['language'],
            sessionId: $sessionId,
            type: 'greeting',
            metadata: [
                'time_of_day' => $greeting['time_of_day'],
            ]
        );
    }

    public function processMessage(ChatMessageData $messageData): ChatResponseData
    {
        try {
            $language = $messageData->language ?? 'en';

            $prompt = $this->buildSimplePrompt($messageData->message, $language);

            $llmResponse = $this->llmService->generateResponse(
                $prompt,
                'chatgpt',
                [
                    'language' => $language,
                    'session_id' => $messageData->sessionId,
                ]
            );

            return new ChatResponseData(
                message: $llmResponse->content,
                language: $language,
                sessionId: $messageData->sessionId,
                type: 'response',
                metadata: [
                    'llm_driver' => $llmResponse->driver,
                    'processed_at' => now()->toISOString(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Chat message processing failed', [
                'message' => $messageData->message,
                'language' => $messageData->language,
                'error' => $e->getMessage(),
            ]);

            return $this->generateErrorResponse($messageData->language ?? 'en', $messageData->sessionId);
        }
    }

    private function buildSimplePrompt(string $message, string $language): string
    {
        $systemPrompt = $this->getSimpleSystemPrompt($language);

        return "{$systemPrompt}\n\nMensagem do utilizador: {$message}";
    }

    private function getSimpleSystemPrompt(string $language): string
    {
        return match ($language) {
            'pt' => 'Você é um assistente AI especializado em turismo e viagens. 
                    Responda sempre em português de forma clara e direta.
                    Seja útil e forneça informações práticas sobre destinos, hotéis, atividades e orçamentos.',
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
                       Be helpful and provide practical information about destinations, hotels, activities and budgets.',
        };
    }

    private function generateErrorResponse(string $language, ?string $sessionId): ChatResponseData
    {
        $errorMessages = [
            'pt' => 'Desculpe, ocorreu um erro ao processar sua mensagem. Tente novamente em alguns momentos.',
            'es' => 'Lo siento, ocurrió un error al procesar tu mensaje. Inténtalo de nuevo en unos momentos.',
            'fr' => 'Désolé, une erreur s\'est produite lors du traitement de votre message. Réessayez dans quelques instants.',
            'de' => 'Entschuldigung, beim Verarbeiten Ihrer Nachricht ist ein Fehler aufgetreten. Versuchen Sie es in wenigen Augenblicken erneut.',
            'it' => 'Scusa, si è verificato un errore durante l\'elaborazione del tuo messaggio. Riprova tra qualche momento.',
            'en' => 'Sorry, an error occurred while processing your message. Please try again in a few moments.',
        ];

        return new ChatResponseData(
            message: $errorMessages[$language] ?? $errorMessages['en'],
            language: $language,
            sessionId: $sessionId,
            type: 'error',
            metadata: [
                'error_type' => 'processing_error',
                'timestamp' => now()->toISOString(),
            ]
        );
    }

    private function generateSessionId(): string
    {
        return 'chat_'.uniqid().'_'.time();
    }
}
