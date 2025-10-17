# Sistema LLM - Documentação

## Visão Geral

O sistema LLM foi projetado para ser completamente abstrato e extensível, permitindo a integração com diferentes provedores de LLM através de drivers. A comunicação é feita de forma assíncrona usando Jobs e Laravel Horizon.

## Arquitetura

### Interface Abstrata
- `LLMDriverInterface`: Contrato que todos os drivers devem implementar
- Métodos obrigatórios: `generateResponse()`, `getName()`, `isAvailable()`

### Drivers Implementados
- `ChatGPTDriver`: Integração com OpenAI GPT-3.5-turbo
- Fácil adição de novos drivers (Claude, Gemini, etc.)

### Componentes Principais

#### 1. LLMService
- Gerencia todos os drivers registrados
- Fornece interface unificada para comunicação
- Tratamento de erros centralizado

#### 2. ProcessLLMRequestJob
- Job assíncrono para processamento de solicitações
- Integração automática com TravelRequest
- Logs detalhados de sucesso/erro

#### 3. LLMResponseData
- DTO para respostas padronizadas
- Inclui metadados e informações de erro

## Configuração

### Variáveis de Ambiente
```env
# OpenAI Configuration
OPENAI_API_KEY=your_openai_api_key_here
OPENAI_MODEL=gpt-3.5-turbo
OPENAI_MAX_TOKENS=1000

# Horizon Configuration
HORIZON_NAME=aitravel
HORIZON_DOMAIN=null
HORIZON_PATH=horizon
```

### Laravel Horizon
O sistema está configurado para usar Laravel Horizon para gerenciamento de filas:
- Monitoramento em tempo real
- Métricas de performance
- Retry automático de jobs falhados

## Uso

### Básico
```php
use App\Domain\LLM\Services\LLMService;

$service = new LLMService();
$response = $service->generateResponse('Prompt aqui', 'chatgpt');
```

### Com Contexto
```php
$response = $service->generateResponse(
    'Recomende hotéis em Lisboa',
    'chatgpt',
    ['budget' => 1000, 'preferences' => ['beach', 'culture']]
);
```

### Integração com TravelRequest
```php
use App\Domain\TravelRequests\Services\TravelRequestService;

$service = new TravelRequestService();
$service->initiateLLMAnalysis($travelRequest, 'chatgpt');
```

## Adicionando Novos Drivers

### 1. Implementar Interface
```php
class ClaudeDriver implements LLMDriverInterface
{
    public function generateResponse(string $prompt, array $context = []): string
    {
        // Implementação específica do Claude
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
// Em LLMService::registerDrivers()
$this->registerDriver('claude', new ClaudeDriver(
    apiKey: config('services.claude.api_key'),
));
```

## Status de TravelRequest

O sistema atualiza automaticamente o status das solicitações:
- `pending`: Solicitação criada
- `completed`: Análise de mercado concluída
- `llm_processed`: Análise LLM concluída
- `llm_error`: Erro no processamento LLM

## Monitoramento

### Logs
- Sucesso: `LLM Request processed successfully`
- Erro: `LLM Request processing failed`
- Detalhes: ID da solicitação, driver usado, erro específico

### Horizon Dashboard
- Acesse `/horizon` para monitorar jobs
- Métricas de performance em tempo real
- Histórico de jobs processados/falhados

## Testes

O sistema inclui testes abrangentes:
- Testes de drivers individuais
- Testes de integração com Jobs
- Testes de disponibilidade de drivers
- Testes de registro de drivers customizados

Execute: `php artisan test tests/Feature/LLMServiceTest.php`

## Exemplo de Resposta LLM

```json
{
  "search_results": {
    "hotels": [...],
    "car_rentals": [...],
    "activities": [...],
    "llm_recommendations": "Baseado nas suas preferências de praia e cultura, recomendo...",
    "llm_driver": "chatgpt",
    "llm_metadata": {
      "prompt_length": 245,
      "context_count": 3,
      "processed_at": "2025-10-17T08:30:00.000000Z"
    },
    "llm_processed_at": "2025-10-17T08:30:00.000000Z"
  },
  "status": "llm_processed"
}
```

## Próximos Passos

1. **Adicionar mais drivers**: Claude, Gemini, Llama
2. **Cache de respostas**: Evitar chamadas duplicadas
3. **Rate limiting**: Controlar uso de APIs
4. **Métricas avançadas**: Tempo de resposta, custos
5. **Fallback automático**: Trocar driver em caso de falha
