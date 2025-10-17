<?php

namespace App\Domain\Chat\Services;

use Illuminate\Support\Facades\Cache;

class ChatContextService
{
    private const CACHE_PREFIX = 'chat_context_';

    private const CACHE_TTL = 3600; // 1 hora

    public function getContext(string $sessionId): array
    {
        return Cache::get(self::CACHE_PREFIX.$sessionId, [
            'messages' => [],
            'user_preferences' => [],
            'current_intent' => null,
            'travel_context' => null,
            'suggestions' => [],
            'detected_language' => null,
            'language_confidence' => 0.0,
        ]);
    }

    public function updateContext(string $sessionId, array $updates): void
    {
        $context = $this->getContext($sessionId);
        $context = array_merge($context, $updates);

        Cache::put(self::CACHE_PREFIX.$sessionId, $context, self::CACHE_TTL);
    }

    public function addMessage(string $sessionId, string $role, string $content): void
    {
        $context = $this->getContext($sessionId);
        $context['messages'][] = [
            'role' => $role,
            'content' => $content,
            'timestamp' => now()->toISOString(),
        ];

        // Manter apenas as últimas 20 mensagens
        if (count($context['messages']) > 20) {
            $context['messages'] = array_slice($context['messages'], -20);
        }

        $this->updateContext($sessionId, ['messages' => $context['messages']]);
    }

    public function detectAndUpdateLanguage(string $sessionId, string $message): string
    {
        $languageDetection = app(\App\Domain\Chat\Services\LanguageDetectionService::class);
        $detectedLanguage = $languageDetection->detectLanguage($message);
        $confidence = $languageDetection->getConfidenceScore($message, $detectedLanguage);

        // Só atualizar se a confiança for alta (>= 0.3) e for diferente do idioma atual
        $context = $this->getContext($sessionId);
        $currentLanguage = $context['detected_language'];

        if ($confidence >= 0.3 && $detectedLanguage !== $currentLanguage) {
            $this->updateContext($sessionId, [
                'detected_language' => $detectedLanguage,
                'language_confidence' => $confidence,
            ]);
        }

        return $detectedLanguage;
    }

    public function getDetectedLanguage(string $sessionId): ?string
    {
        $context = $this->getContext($sessionId);

        return $context['detected_language'];
    }

    public function detectIntent(string $message): string
    {
        $message = strtolower($message);

        $intents = [
            'travel_planning' => ['viagem', 'travel', 'destino', 'destination', 'hotel', 'hospedagem', 'accommodation'],
            'budget_inquiry' => ['orçamento', 'budget', 'preço', 'price', 'custo', 'cost', 'quanto', 'how much'],
            'activity_search' => ['atividade', 'activity', 'passeio', 'tour', 'excursão', 'excursion', 'o que fazer', 'what to do'],
            'transportation' => ['transporte', 'transport', 'avião', 'plane', 'carro', 'car', 'táxi', 'taxi'],
            'accommodation' => ['hotel', 'hospedagem', 'accommodation', 'alojamento', 'quarto', 'room'],
            'restaurant' => ['restaurante', 'restaurant', 'comida', 'food', 'jantar', 'dinner', 'almoço', 'lunch'],
            'weather' => ['tempo', 'weather', 'clima', 'climate', 'chuva', 'rain', 'sol', 'sun'],
            'general_info' => ['informação', 'information', 'ajuda', 'help', 'como', 'how', 'onde', 'where'],
        ];

        foreach ($intents as $intent => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    return $intent;
                }
            }
        }

        return 'general_info';
    }

    public function extractTravelInfo(string $message): array
    {
        $info = [];

        // Detectar datas
        if (preg_match('/(\d{1,2})\/(\d{1,2})\/(\d{4})/', $message, $matches)) {
            $info['dates'] = $matches[0];
        }

        // Detectar números de pessoas
        if (preg_match('/(\d+)\s*(pessoas?|people|adultos?|adults|crianças?|children)/i', $message, $matches)) {
            $info['people'] = (int) $matches[1];
        }

        // Detectar orçamento
        if (preg_match('/(\d+)\s*(€|euros?|dollars?|\$)/i', $message, $matches)) {
            $info['budget'] = (int) $matches[1];
        }

        // Detectar destinos (lista básica)
        $destinations = [
            'lisboa', 'lisbon', 'porto', 'porto', 'madrid', 'barcelona', 'paris', 'london', 'roma', 'rome',
            'berlin', 'amsterdam', 'praga', 'prague', 'viena', 'vienna', 'atenas', 'athens',
        ];

        foreach ($destinations as $destination) {
            if (str_contains(strtolower($message), $destination)) {
                $info['destination'] = $destination;
                break;
            }
        }

        return $info;
    }

    public function generateSuggestions(string $intent, array $context): array
    {
        return match ($intent) {
            'travel_planning' => [
                'Precisa de ajuda com datas específicas?',
                'Tem preferências de destino?',
                'Quantas pessoas vão viajar?',
                'Qual o seu orçamento aproximado?',
            ],
            'budget_inquiry' => [
                'Para quantas pessoas?',
                'Que tipo de acomodação prefere?',
                'Inclui transporte?',
                'Que atividades planeja fazer?',
            ],
            'activity_search' => [
                'Prefere atividades culturais ou aventura?',
                'Tem interesse em museus?',
                'Gosta de atividades ao ar livre?',
                'Prefere tours guiados?',
            ],
            'accommodation' => [
                'Prefere hotel ou apartamento?',
                'Qual a localização ideal?',
                'Tem preferências de preço?',
                'Precisa de amenities específicas?',
            ],
            default => [
                'Como posso ajudar com o seu planeamento de viagem?',
                'Tem alguma preferência específica?',
                'Precisa de informações sobre algum destino?',
                'Quer ajuda com orçamento?',
            ],
        };
    }

    public function clearContext(string $sessionId): void
    {
        Cache::forget(self::CACHE_PREFIX.$sessionId);
    }
}
