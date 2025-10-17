<?php

namespace App\Domain\Chat\Services;

class TravelTemplateService
{
    private array $requiredFields = [
        'full_name' => 'Nome completo',
        'email' => 'Email',
        'mobile_phone' => 'Telefone móvel',
        'city_from' => 'Cidade de origem',
        'city_destination' => 'Cidade de destino',
        'checkin_datetime' => 'Data e hora de check-in',
        'checkout_datetime' => 'Data e hora de check-out',
        'adults' => 'Número de adultos',
        'children' => 'Número de crianças',
        'need_car' => 'Precisa de carro (sim/não)',
    ];

    private array $fieldQuestions = [
        'pt' => [
            'full_name' => 'Qual é o seu nome completo?',
            'email' => 'Qual é o seu email?',
            'mobile_phone' => 'Qual é o seu número de telefone móvel?',
            'city_from' => 'De que cidade você está a partir?',
            'city_destination' => 'Para que cidade você quer viajar?',
            'checkin_datetime' => 'Qual é a data e hora de check-in? (formato: DD/MM/YYYY HH:MM)',
            'checkout_datetime' => 'Qual é a data e hora de check-out? (formato: DD/MM/YYYY HH:MM)',
            'adults' => 'Quantos adultos vão viajar?',
            'children' => 'Quantas crianças vão viajar? (0 se não houver)',
            'need_car' => 'Você precisa de aluguer de carro? (sim ou não)',
        ],
        'en' => [
            'full_name' => 'What is your full name?',
            'email' => 'What is your email address?',
            'mobile_phone' => 'What is your mobile phone number?',
            'city_from' => 'Which city are you departing from?',
            'city_destination' => 'Which city do you want to travel to?',
            'checkin_datetime' => 'What is your check-in date and time? (format: DD/MM/YYYY HH:MM)',
            'checkout_datetime' => 'What is your check-out date and time? (format: DD/MM/YYYY HH:MM)',
            'adults' => 'How many adults are traveling?',
            'children' => 'How many children are traveling? (0 if none)',
            'need_car' => 'Do you need a car rental? (yes or no)',
        ],
        'es' => [
            'full_name' => '¿Cuál es tu nombre completo?',
            'email' => '¿Cuál es tu dirección de email?',
            'mobile_phone' => '¿Cuál es tu número de teléfono móvil?',
            'city_from' => '¿Desde qué ciudad partes?',
            'city_destination' => '¿A qué ciudad quieres viajar?',
            'checkin_datetime' => '¿Cuál es la fecha y hora de check-in? (formato: DD/MM/YYYY HH:MM)',
            'checkout_datetime' => '¿Cuál es la fecha y hora de check-out? (formato: DD/MM/YYYY HH:MM)',
            'adults' => '¿Cuántos adultos van a viajar?',
            'children' => '¿Cuántos niños van a viajar? (0 si no hay)',
            'need_car' => '¿Necesitas alquiler de coche? (sí o no)',
        ],
    ];

    public function getRequiredFields(): array
    {
        return $this->requiredFields;
    }

    public function getFieldQuestion(string $field, string $language = 'pt'): string
    {
        return $this->fieldQuestions[$language][$field] ?? $this->fieldQuestions['pt'][$field];
    }

    public function getNextMissingField(array $currentData, string $language = 'pt'): ?string
    {
        foreach ($this->requiredFields as $field => $label) {
            if (! isset($currentData[$field]) || empty($currentData[$field])) {
                return $field;
            }
        }

        return null;
    }

    public function getCompletionStatus(array $currentData): array
    {
        $total = count($this->requiredFields);
        $filled = 0;
        $missing = [];

        foreach ($this->requiredFields as $field => $label) {
            if (isset($currentData[$field]) && ! empty($currentData[$field])) {
                $filled++;
            } else {
                $missing[] = $field;
            }
        }

        return [
            'total' => $total,
            'filled' => $filled,
            'missing' => $missing,
            'percentage' => round(($filled / $total) * 100, 1),
            'is_complete' => $filled === $total,
        ];
    }

    public function getWelcomeMessage(string $language = 'pt'): string
    {
        return match ($language) {
            'pt' => 'Olá! Sou o seu assistente AI Travel. Vou ajudá-lo a preencher as informações necessárias para criar o seu pacote de viagem. Vamos começar!',
            'en' => 'Hello! I am your AI Travel assistant. I will help you fill in the necessary information to create your travel package. Let\'s get started!',
            'es' => '¡Hola! Soy tu asistente AI Travel. Te ayudo a completar la información necesaria para crear tu paquete de viaje. ¡Empecemos!',
            default => 'Hello! I am your AI Travel assistant. I will help you fill in the necessary information to create your travel package. Let\'s get started!',
        };
    }

    public function getCompletionMessage(string $language = 'pt'): string
    {
        return match ($language) {
            'pt' => 'Perfeito! Todas as informações foram recolhidas. O seu pedido será processado e receberá uma proposta de viagem personalizada em breve.',
            'en' => 'Perfect! All information has been collected. Your request will be processed and you will receive a personalized travel proposal soon.',
            'es' => '¡Perfecto! Toda la información ha sido recopilada. Su solicitud será procesada y recibirá una propuesta de viaje personalizada pronto.',
            default => 'Perfect! All information has been collected. Your request will be processed and you will receive a personalized travel proposal soon.',
        };
    }

    public function extractFieldValue(string $message, string $field): ?string
    {
        $lowerMessage = strtolower($message);

        return match ($field) {
            'full_name' => $this->extractName($message),
            'email' => $this->extractEmail($message),
            'mobile_phone' => $this->extractPhone($message),
            'city_from' => $this->extractCity($message, 'from'),
            'city_destination' => $this->extractCity($message, 'destination'),
            'checkin_datetime' => $this->extractDateTime($message, 'checkin'),
            'checkout_datetime' => $this->extractDateTime($message, 'checkout'),
            'adults' => $this->extractNumber($message, 'adults'),
            'children' => $this->extractNumber($message, 'children'),
            'need_car' => $this->extractYesNo($message),
            default => null,
        };
    }

    public function extractTravelDataFromMessage(string $message): array
    {
        $extractedData = [];
        $lowerMessage = strtolower($message);

        // Extrair número de pessoas
        $peopleCount = $this->extractPeopleCount($message);
        if ($peopleCount) {
            $extractedData['adults'] = (string) $peopleCount;
        }

        // Extrair cidades usando uma abordagem mais inteligente
        $cities = $this->extractCitiesFromMessage($message);
        if (isset($cities['from'])) {
            $extractedData['city_from'] = $cities['from'];
        }
        if (isset($cities['destination'])) {
            $extractedData['city_destination'] = $cities['destination'];
        }

        // Extrair outras informações se presentes
        $email = $this->extractEmail($message);
        if ($email) {
            $extractedData['email'] = $email;
        }

        $phone = $this->extractPhone($message);
        if ($phone) {
            $extractedData['mobile_phone'] = $phone;
        }

        $name = $this->extractName($message);
        if ($name) {
            $extractedData['full_name'] = $name;
        }

        return $extractedData;
    }

    private function extractCitiesFromMessage(string $message): array
    {
        $cities = [];
        $lowerMessage = strtolower($message);

        // Busca específica por cidades conhecidas primeiro (preservando capitalização original)
        $knownCitiesMap = [
            'rio de janeiro' => 'Rio de Janeiro',
            'são paulo' => 'São Paulo',
            'sao paulo' => 'São Paulo',
            'porto' => 'Porto',
            'lisboa' => 'Lisboa',
            'madrid' => 'Madrid',
            'barcelona' => 'Barcelona',
            'paris' => 'Paris',
            'london' => 'London',
            'new york' => 'New York',
            'miami' => 'Miami',
            'los angeles' => 'Los Angeles',
            'berlin' => 'Berlin',
            'amsterdam' => 'Amsterdam',
            'roma' => 'Roma',
            'milan' => 'Milan',
            'vienna' => 'Vienna',
            'prague' => 'Prague',
        ];

        $foundCities = [];
        foreach ($knownCitiesMap as $lowerCity => $properCity) {
            if (str_contains($lowerMessage, $lowerCity)) {
                $foundCities[] = $properCity;
            }
        }

        // Se encontrou 2 ou mais cidades, usar a ordem de aparição na mensagem
        if (count($foundCities) >= 2) {
            // Encontrar a posição de cada cidade na mensagem
            $cityPositions = [];
            foreach ($foundCities as $city) {
                $pos = strpos($lowerMessage, strtolower($city));
                if ($pos !== false) {
                    $cityPositions[$city] = $pos;
                }
            }

            // Ordenar por posição na mensagem
            asort($cityPositions);
            $orderedCities = array_keys($cityPositions);

            $cities['from'] = $orderedCities[0];
            $cities['destination'] = $orderedCities[1];
        } elseif (count($foundCities) == 1) {
            // Se encontrou apenas uma cidade, tentar determinar se é origem ou destino
            $city = $foundCities[0];
            $lowerCity = strtolower($city);

            // Verificar se há indicadores de origem
            $fromIndicators = ['de '.$lowerCity, 'from '.$lowerCity, 'desde '.$lowerCity];
            $toIndicators = ['para '.$lowerCity, 'to '.$lowerCity, 'até '.$lowerCity];

            $isFrom = false;
            $isTo = false;

            foreach ($fromIndicators as $indicator) {
                if (str_contains($lowerMessage, $indicator)) {
                    $isFrom = true;
                    break;
                }
            }

            foreach ($toIndicators as $indicator) {
                if (str_contains($lowerMessage, $indicator)) {
                    $isTo = true;
                    break;
                }
            }

            if ($isFrom && ! $isTo) {
                $cities['from'] = $city;
            } elseif ($isTo && ! $isFrom) {
                $cities['destination'] = $city;
            } else {
                // Se não conseguiu determinar, assumir que é destino
                $cities['destination'] = $city;
            }
        }

        return $cities;
    }

    private function extractPeopleCount(string $message): ?int
    {
        $lowerMessage = strtolower($message);

        // Padrões para extrair número de pessoas
        $patterns = [
            '/(\d+)\s*(?:pessoas?|people|personas?)/i',
            '/(\d+)\s*(?:adultos?|adults|adultos?)/i',
            '/(\d+)\s*(?:viajantes?|travelers?|viajantes?)/i',
            '/(\d+)\s*(?:passageiros?|passengers?|pasajeros?)/i',
            '/(?:para|for|para)\s*(\d+)\s*(?:pessoas?|people|personas?)/i',
            '/(?:preciso|need|necesito)\s*(?:de\s*)?(\d+)\s*(?:pessoas?|people|personas?)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message, $matches)) {
                $count = (int) $matches[1];
                if ($count > 0 && $count <= 20) { // Limite razoável
                    return $count;
                }
            }
        }

        // Procurar por números simples que podem indicar pessoas
        if (preg_match('/\b(\d+)\b/', $message, $matches)) {
            $count = (int) $matches[1];
            if ($count >= 1 && $count <= 10) { // Limite mais conservador para números simples
                // Verificar se o contexto sugere que é número de pessoas
                $contextWords = ['pessoas', 'people', 'adultos', 'adults', 'viajantes', 'travelers', 'para', 'for'];
                foreach ($contextWords as $word) {
                    if (str_contains($lowerMessage, $word)) {
                        return $count;
                    }
                }
            }
        }

        return null;
    }

    private function extractCityFromMessage(string $message, string $type): ?string
    {
        $lowerMessage = strtolower($message);

        // Busca específica por cidades conhecidas primeiro (preservando capitalização original)
        $knownCitiesMap = [
            'rio de janeiro' => 'Rio de Janeiro',
            'são paulo' => 'São Paulo',
            'sao paulo' => 'São Paulo',
            'porto' => 'Porto',
            'lisboa' => 'Lisboa',
            'madrid' => 'Madrid',
            'barcelona' => 'Barcelona',
            'paris' => 'Paris',
            'london' => 'London',
            'new york' => 'New York',
            'miami' => 'Miami',
            'los angeles' => 'Los Angeles',
            'berlin' => 'Berlin',
            'amsterdam' => 'Amsterdam',
            'roma' => 'Roma',
            'milan' => 'Milan',
            'vienna' => 'Vienna',
            'prague' => 'Prague',
        ];

        foreach ($knownCitiesMap as $lowerCity => $properCity) {
            if (str_contains($lowerMessage, $lowerCity)) {
                return $properCity;
            }
        }

        if ($type === 'from') {
            // Padrões para cidade de origem
            $patterns = [
                '/(?:de|from|desde)\s+([a-zA-ZÀ-ÿ\s]+?)(?:\s+para|\s+to|\s+até|\s+for|\s+going|\s+traveling)/i',
                '/(?:parto|leaving|departing|sou de|vou partir)\s+(?:de\s+)?([a-zA-ZÀ-ÿ\s]+?)(?:\s+para|\s+to|\s+até|\s+for)/i',
                '/(?:origem|origin|starting)\s+(?:de\s+)?([a-zA-ZÀ-ÿ\s]+)/i',
            ];
        } else {
            // Padrões para cidade de destino
            $patterns = [
                '/(?:para|to|até|going to|traveling to|voy a)\s+([a-zA-ZÀ-ÿ\s]+?)(?:\s+de|\s+from|\s+desde|\s+com|\s+with)/i',
                '/(?:destino|destination|quero ir|vou para)\s+(?:para\s+)?([a-zA-ZÀ-ÿ\s]+)/i',
            ];
        }

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message, $matches) && isset($matches[1])) {
                $city = trim($matches[1]);
                // Limpar a cidade de palavras desnecessárias
                $city = preg_replace('/\b(?:de|da|do|das|dos|para|com|para|até)\b/i', '', $city);
                $city = trim($city);

                if (strlen($city) >= 3 && strlen($city) <= 50) {
                    return $city;
                }
            }
        }

        return null;
    }

    private function extractName(string $message): ?string
    {
        // Procurar por padrões como "meu nome é", "sou", "chamo-me"
        $patterns = [
            '/meu nome é ([a-zA-ZÀ-ÿ\s]+)/i',
            '/sou ([a-zA-ZÀ-ÿ\s]+?)(?:,|\.|$)/i',
            '/chamo-me ([a-zA-ZÀ-ÿ\s]+)/i',
            '/my name is ([a-zA-ZÀ-ÿ\s]+)/i',
            '/i am ([a-zA-ZÀ-ÿ\s]+?)(?:,|\.|$)/i',
            '/mi nombre es ([a-zA-ZÀ-ÿ\s]+)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message, $matches)) {
                $name = trim($matches[1]);
                // Limpar vírgulas e pontos no final
                $name = rtrim($name, '.,');

                return $name;
            }
        }

        // Se não encontrou padrões específicos, verificar se é um nome simples (2-3 palavras)
        // Mas apenas se a mensagem não contém contexto de conversa
        if (! str_contains($message, 'Histórico da conversa:') && ! str_contains($message, 'Mensagem atual do utilizador:')) {
            $trimmed = trim($message);
            if (preg_match('/^[a-zA-ZÀ-ÿ\s]{2,50}$/', $trimmed) && substr_count($trimmed, ' ') <= 2) {
                return $trimmed;
            }
        }

        // Se contém contexto de conversa, extrair da última mensagem do utilizador
        if (str_contains($message, 'Mensagem atual do utilizador:')) {
            if (preg_match('/Mensagem atual do utilizador:\s*([^\n\r]+)/i', $message, $matches)) {
                $name = trim($matches[1]);
                if (preg_match('/^[a-zA-ZÀ-ÿ\s]{2,50}$/', $name) && substr_count($name, ' ') <= 2) {
                    return $name;
                }
            }
        }

        return null;
    }

    private function extractEmail(string $message): ?string
    {
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $message, $matches)) {
            return $matches[0];
        }

        return null;
    }

    private function extractPhone(string $message): ?string
    {
        // Se contém contexto de conversa, extrair da última mensagem do utilizador
        if (str_contains($message, 'Mensagem atual do utilizador:')) {
            if (preg_match('/Mensagem atual do utilizador:\s*([^\n\r]+)/i', $message, $matches)) {
                $phone = trim($matches[1]);
                if (preg_match('/[\+]?[0-9\s\-\(\)]{8,}/', $phone, $phoneMatches)) {
                    return trim($phoneMatches[0]);
                }
            }
        }

        // Padrão normal para mensagens sem contexto
        if (preg_match('/[\+]?[0-9\s\-\(\)]{8,}/', $message, $matches)) {
            return trim($matches[0]);
        }

        return null;
    }

    private function extractCity(string $message, string $type): ?string
    {
        // Padrões para cidade de origem
        if ($type === 'from') {
            $patterns = [
                '/parto de ([a-zA-ZÀ-ÿ\s]+)/i',
                '/sou de ([a-zA-ZÀ-ÿ\s]+)/i',
                '/vou partir de ([a-zA-ZÀ-ÿ\s]+)/i',
                '/departing from ([a-zA-ZÀ-ÿ\s]+)/i',
                '/leaving from ([a-zA-ZÀ-ÿ\s]+)/i',
            ];
        } else {
            // Padrões para cidade de destino
            $patterns = [
                '/quero ir para ([a-zA-ZÀ-ÿ\s]+)/i',
                '/vou para ([a-zA-ZÀ-ÿ\s]+)/i',
                '/destino ([a-zA-ZÀ-ÿ\s]+)/i',
                '/going to ([a-zA-ZÀ-ÿ\s]+)/i',
                '/traveling to ([a-zA-ZÀ-ÿ\s]+)/i',
                '/voy a ([a-zA-ZÀ-ÿ\s]+)/i',
            ];
        }

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message, $matches)) {
                return trim($matches[1]);
            }
        }

        return null;
    }

    private function extractDateTime(string $message, string $type): ?string
    {
        // Padrões para datas
        $patterns = [
            '/(\d{1,2})\/(\d{1,2})\/(\d{4})\s+(\d{1,2}):(\d{2})/',
            '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
            '/(\d{4})-(\d{1,2})-(\d{1,2})\s+(\d{1,2}):(\d{2})/',
            '/(\d{4})-(\d{1,2})-(\d{1,2})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message, $matches)) {
                if (count($matches) >= 4) {
                    return $matches[0];
                }
            }
        }

        return null;
    }

    private function extractNumber(string $message, string $type): ?string
    {
        if (preg_match('/\b(\d+)\b/', $message, $matches)) {
            return $matches[1];
        }

        return null;
    }

    private function extractYesNo(string $message): ?string
    {
        $lowerMessage = strtolower($message);

        if (str_contains($lowerMessage, 'sim') || str_contains($lowerMessage, 'yes') || str_contains($lowerMessage, 'sí')) {
            return 'sim';
        }

        if (str_contains($lowerMessage, 'não') || str_contains($lowerMessage, 'no') || str_contains($lowerMessage, 'nao')) {
            return 'não';
        }

        return null;
    }
}
