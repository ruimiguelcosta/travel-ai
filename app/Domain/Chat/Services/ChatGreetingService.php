<?php

namespace App\Domain\Chat\Services;

class ChatGreetingService
{
    private array $greetings = [
        'pt' => [
            'morning' => 'Bom dia',
            'afternoon' => 'Boa tarde',
            'evening' => 'Boa noite',
        ],
        'en' => [
            'morning' => 'Good morning',
            'afternoon' => 'Good afternoon',
            'evening' => 'Good evening',
        ],
        'es' => [
            'morning' => 'Buenos días',
            'afternoon' => 'Buenas tardes',
            'evening' => 'Buenas noches',
        ],
        'fr' => [
            'morning' => 'Bonjour',
            'afternoon' => 'Bon après-midi',
            'evening' => 'Bonsoir',
        ],
        'de' => [
            'morning' => 'Guten Morgen',
            'afternoon' => 'Guten Tag',
            'evening' => 'Guten Abend',
        ],
        'it' => [
            'morning' => 'Buongiorno',
            'afternoon' => 'Buon pomeriggio',
            'evening' => 'Buonasera',
        ],
    ];

    private array $welcomeMessages = [
        'pt' => 'Sou o seu assistente AI Travel. Como posso ajudar você hoje?',
        'en' => 'I am your AI Travel assistant. How can I help you today?',
        'es' => 'Soy tu asistente de AI Travel. ¿Cómo puedo ayudarte hoy?',
        'fr' => 'Je suis votre assistant AI Travel. Comment puis-je vous aider aujourd\'hui?',
        'de' => 'Ich bin Ihr AI Travel-Assistent. Wie kann ich Ihnen heute helfen?',
        'it' => 'Sono il tuo assistente AI Travel. Come posso aiutarti oggi?',
    ];

    public function generateGreeting(?string $browserLanguage = null): array
    {
        $language = $this->detectLanguage($browserLanguage);
        $timeOfDay = $this->getTimeOfDay();

        $greeting = $this->greetings[$language][$timeOfDay] ?? $this->greetings['en'][$timeOfDay];
        $welcomeMessage = $this->welcomeMessages[$language] ?? $this->welcomeMessages['en'];

        return [
            'language' => $language,
            'greeting' => $greeting,
            'welcome_message' => $welcomeMessage,
            'full_message' => "{$greeting}! {$welcomeMessage}",
            'time_of_day' => $timeOfDay,
        ];
    }

    public function detectLanguage(?string $browserLanguage = null): string
    {
        if (! $browserLanguage) {
            return 'en';
        }

        $language = strtolower(substr($browserLanguage, 0, 2));

        return match ($language) {
            'pt' => 'pt',
            'es' => 'es',
            'fr' => 'fr',
            'de' => 'de',
            'it' => 'it',
            default => 'en',
        };
    }

    private function getTimeOfDay(): string
    {
        $hour = (int) now()->format('H');

        return match (true) {
            $hour >= 5 && $hour < 12 => 'morning',
            $hour >= 12 && $hour < 18 => 'afternoon',
            default => 'evening',
        };
    }

    public function getSupportedLanguages(): array
    {
        return array_keys($this->greetings);
    }
}
