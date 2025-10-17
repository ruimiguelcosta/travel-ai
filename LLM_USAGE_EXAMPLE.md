# Exemplo de Uso do Sistema LLM

## Configuração Inicial

### 1. Configurar Variáveis de Ambiente
Adicione ao seu arquivo `.env`:

```env
# OpenAI Configuration
OPENAI_API_KEY=sk-your-openai-api-key-here
OPENAI_MODEL=gpt-3.5-turbo
OPENAI_MAX_TOKENS=1000

# Horizon Configuration
HORIZON_NAME=aitravel
HORIZON_DOMAIN=null
HORIZON_PATH=horizon
```

### 2. Iniciar Laravel Horizon
```bash
php artisan horizon
```

## Uso da API

### Criar Solicitação de Viagem com Análise LLM

```bash
curl -X POST http://127.0.0.1:8000/api/travel-requests \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Maria Santos",
    "email": "maria@example.com",
    "phone": "+351912345679",
    "checkin_date": "2025-11-15",
    "checkout_date": "2025-11-22",
    "destination_country": "Espanha",
    "destination_city": "Madrid",
    "preferences": ["culture", "food", "museums"],
    "adults": 1,
    "children": 0,
    "budget": 800.00
  }'
```

### Resposta Esperada

```json
{
  "message": "Solicitação de viagem criada com sucesso. Análise LLM em processamento.",
  "travel_request": {
    "id": 1,
    "name": "Maria Santos",
    "email": "maria@example.com",
    "phone": "+351912345679",
    "checkin_date": "2025-11-15",
    "checkout_date": "2025-11-22",
    "destination_country": "Espanha",
    "destination_city": "Madrid",
    "preferences": ["culture", "food", "museums"],
    "adults": 1,
    "children": 0,
    "budget": 800.00,
    "status": "completed",
    "search_results": {
      "hotels": [...],
      "car_rentals": [...],
      "activities": [...],
      "total_estimated_cost": 1050.00
    },
    "created_at": "2025-10-17T08:30:00.000000Z",
    "updated_at": "2025-10-17T08:30:00.000000Z"
  }
}
```

### Verificar Status da Análise LLM

Após alguns segundos, a solicitação será atualizada com as recomendações do LLM:

```bash
curl -X GET http://127.0.0.1:8000/api/travel-requests/1
```

### Resposta com Análise LLM Completa

```json
{
  "id": 1,
  "name": "Maria Santos",
  "email": "maria@example.com",
  "status": "llm_processed",
  "search_results": {
    "hotels": [...],
    "car_rentals": [...],
    "activities": [...],
    "total_estimated_cost": 1050.00,
    "llm_recommendations": "Baseado nas suas preferências de cultura, comida e museus, recomendo:\n\n1. **Hotéis Recomendados:**\n   - Hotel NH Collection Madrid Palacio de Tepa (€120/noite)\n   - Hotel Riu Plaza España (€95/noite)\n\n2. **Atividades Culturais:**\n   - Museu do Prado (€15)\n   - Museu Reina Sofía (€12)\n   - Tour gastronómico pelo Mercado de San Miguel (€45)\n\n3. **Restaurantes:**\n   - Casa Lucio (tapas tradicionais)\n   - DiverXO (experiência gastronómica)\n\n4. **Transporte:**\n   - Metro Madrid (€2.60 por viagem)\n   - Abono Turístico (€8.40/dia)\n\n**Orçamento Estimado:** €800-€1000 para 7 dias",
    "llm_driver": "chatgpt",
    "llm_metadata": {
      "prompt_length": 245,
      "context_count": 3,
      "processed_at": "2025-10-17T08:30:15.000000Z"
    },
    "llm_processed_at": "2025-10-17T08:30:15.000000Z"
  }
}
```

## Monitoramento

### Dashboard Horizon
Acesse `http://127.0.0.1:8000/horizon` para monitorar:
- Jobs em processamento
- Jobs concluídos
- Jobs falhados
- Métricas de performance

### Logs
Os logs são registrados em `storage/logs/laravel.log`:

```
[2025-10-17 08:30:15] local.INFO: LLM Request processed successfully {"travel_request_id":1,"driver":"chatgpt"}
```

## Adicionando Novos Drivers

### 1. Criar Driver Personalizado

```php
<?php

namespace App\Domain\LLM\Drivers;

use App\Domain\LLM\Contracts\LLMDriverInterface;

class ClaudeDriver implements LLMDriverInterface
{
    public function __construct(
        private ?string $apiKey,
        private string $model = 'claude-3-sonnet-20240229',
    ) {}

    public function generateResponse(string $prompt, array $context = []): string
    {
        // Implementação específica do Claude
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model' => $this->model,
            'max_tokens' => 1000,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
        ]);

        return $response->json()['content'][0]['text'] ?? 'Erro ao comunicar com Claude';
    }

    public function getName(): string
    {
        return 'claude';
    }

    public function isAvailable(): bool
    {
        return !empty($this->apiKey);
    }
}
```

### 2. Registrar no Service

```php
// Em app/Domain/LLM/Services/LLMService.php
private function registerDrivers(): void
{
    $this->registerDriver('chatgpt', new ChatGPTDriver(
        apiKey: config('services.openai.api_key', ''),
        model: config('services.openai.model', 'gpt-3.5-turbo'),
        maxTokens: config('services.openai.max_tokens', 1000),
    ));
    
    $this->registerDriver('claude', new ClaudeDriver(
        apiKey: config('services.claude.api_key', ''),
        model: config('services.claude.model', 'claude-3-sonnet-20240229'),
    ));
}
```

### 3. Usar o Novo Driver

```php
$service = new TravelRequestService();
$service->initiateLLMAnalysis($travelRequest, 'claude');
```

## Troubleshooting

### Erro: "Driver não está disponível"
- Verifique se a API key está configurada
- Confirme se a variável de ambiente está definida

### Erro: "Job falhou"
- Verifique os logs em `storage/logs/laravel.log`
- Confirme se o Horizon está rodando
- Verifique se a API key é válida

### Resposta vazia do LLM
- Verifique se o prompt está bem formado
- Confirme se há créditos na conta da API
- Verifique os limites de rate limiting
