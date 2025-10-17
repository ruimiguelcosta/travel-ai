# Sistema de Chat Dinâmico - Exemplo de Uso

## Funcionalidades Implementadas

### ✅ **Detecção Automática de Idioma**
- Detecta o idioma do browser automaticamente
- Suporta: Português, Inglês, Espanhol, Francês, Alemão, Italiano
- Responde sempre no idioma detectado

### ✅ **Saudação Baseada na Hora**
- **Manhã (5h-12h)**: "Bom dia!"
- **Tarde (12h-18h)**: "Boa tarde!"
- **Noite (18h-5h)**: "Boa noite!"

### ✅ **Sistema de Contexto Inteligente**
- Mantém memória da conversa (últimas 20 mensagens)
- Extrai automaticamente informações de viagem
- Detecta intenções do utilizador
- Gera sugestões contextuais

### ✅ **Detecção de Intenções**
- `travel_planning`: Planeamento de viagem
- `budget_inquiry`: Consultas de orçamento
- `activity_search`: Procura de atividades
- `transportation`: Transporte
- `accommodation`: Alojamento
- `restaurant`: Restaurantes
- `weather`: Tempo
- `general_info`: Informações gerais

### ✅ **Extração Automática de Informações**
- **Datas**: Detecta formatos como "15/11/2025"
- **Pessoas**: Detecta "2 pessoas", "3 adultos", etc.
- **Orçamento**: Detecta "€500", "1000 euros", etc.
- **Destinos**: Detecta cidades conhecidas

## Exemplo de Conversa Dinâmica

### 1. Inicialização do Chat

```bash
curl -X GET http://127.0.0.1:8000/api/chat/initialize \
  -H "Accept-Language: pt-PT,pt;q=0.9"
```

**Resposta:**
```json
{
  "message": "Bom dia! Sou o seu assistente AI Travel. Como posso ajudar você hoje?",
  "language": "pt",
  "session_id": "chat_67890abc_1737100800",
  "type": "greeting",
  "suggestions": [
    "Como posso ajudar com o seu planeamento de viagem?",
    "Tem alguma preferência específica?",
    "Precisa de informações sobre algum destino?",
    "Quer ajuda com orçamento?"
  ],
  "metadata": {
    "time_of_day": "morning",
    "greeting_type": "initial",
    "supported_languages": ["pt", "en", "es", "fr", "de", "it"]
  }
}
```

### 2. Primeira Mensagem do Utilizador

```bash
curl -X POST http://127.0.0.1:8000/api/chat/message \
  -H "Content-Type: application/json" \
  -d '{
    "message": "Olá! Quero planear uma viagem para Lisboa em novembro com 2 pessoas e orçamento de 800 euros",
    "language": "pt",
    "session_id": "chat_67890abc_1737100800"
  }'
```

**Resposta:**
```json
{
  "message": "Excelente! Vou ajudar-te a planear essa viagem para Lisboa em novembro. Com 2 pessoas e um orçamento de €800, temos várias opções interessantes.\n\nPara começar, tens alguma preferência específica para as datas de novembro? E que tipo de experiências procuras em Lisboa - mais culturais, gastronómicas, ou aventura?",
  "language": "pt",
  "session_id": "chat_67890abc_1737100800",
  "type": "response",
  "suggestions": [
    "Precisa de ajuda com datas específicas?",
    "Tem preferências de destino?",
    "Quantas pessoas vão viajar?",
    "Qual o seu orçamento aproximado?"
  ],
  "metadata": {
    "llm_driver": "chatgpt",
    "processed_at": "2025-10-17T10:30:15.000000Z",
    "intent": "travel_planning",
    "extracted_info": {
      "destination": "lisboa",
      "people": 2,
      "budget": 800
    },
    "context_size": 2
  }
}
```

### 3. Continuação da Conversa

```bash
curl -X POST http://127.0.0.1:8000/api/chat/message \
  -H "Content-Type: application/json" \
  -d '{
    "message": "Prefiro atividades culturais e gastronómicas. E gostava de ficar no centro da cidade",
    "language": "pt",
    "session_id": "chat_67890abc_1737100800"
  }'
```

**Resposta:**
```json
{
  "message": "Perfeito! Lisboa tem uma oferta cultural e gastronómica fantástica. Para o centro da cidade, recomendo a zona do Chiado/Bairro Alto ou Alfama.\n\n**Atividades Culturais:**\n- Museu do Fado (Alfama)\n- Mosteiro dos Jerónimos\n- Torre de Belém\n- Museu Nacional de Arte Antiga\n\n**Experiências Gastronómicas:**\n- Mercado da Ribeira (Time Out Market)\n- Pastéis de Belém\n- Restaurantes típicos em Alfama\n\nCom o teu orçamento de €800 para 2 pessoas, conseguimos um hotel 3-4 estrelas no centro. Precisas de ajuda com alojamento específico?",
  "language": "pt",
  "session_id": "chat_67890abc_1737100800",
  "type": "response",
  "suggestions": [
    "Prefere hotel ou apartamento?",
    "Qual a localização ideal?",
    "Tem preferências de preço?",
    "Precisa de amenities específicas?"
  ],
  "metadata": {
    "llm_driver": "chatgpt",
    "processed_at": "2025-10-17T10:32:45.000000Z",
    "intent": "accommodation",
    "extracted_info": {
      "preferences": ["cultural", "gastronomic", "center"]
    },
    "context_size": 4
  }
}
```

## Características do Sistema Dinâmico

### 🧠 **Memória Contextual**
- Lembra-se de informações anteriores
- Constrói sobre conversas passadas
- Mantém preferências do utilizador

### 🎯 **Detecção Inteligente**
- Identifica automaticamente o que o utilizador quer
- Extrai informações relevantes
- Adapta respostas ao contexto

### 💡 **Sugestões Contextuais**
- Oferece sugestões baseadas na intenção
- Perguntas de follow-up inteligentes
- Guia a conversa de forma natural

### 🌍 **Multilíngue**
- Responde no idioma do browser
- Mantém consistência linguística
- Suporta 6 idiomas principais

### ⚡ **Respostas Personalizadas**
- Baseadas no contexto da conversa
- Informações específicas extraídas
- Recomendações adaptadas às preferências

## API Endpoints

### Inicializar Chat
```bash
GET /api/chat/initialize
Headers: Accept-Language: pt-PT,pt;q=0.9
```

### Enviar Mensagem
```bash
POST /api/chat/message
Content-Type: application/json

{
  "message": "Texto da mensagem",
  "language": "pt",
  "session_id": "session_id_opcional",
  "context": {}
}
```

## Configuração

### Variáveis de Ambiente
```env
# OpenAI Configuration
OPENAI_API_KEY=your_openai_api_key_here
OPENAI_MODEL=gpt-3.5-turbo
OPENAI_MAX_TOKENS=1000

# Cache Configuration (para contexto)
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Monitoramento

### Logs de Contexto
```php
// Em storage/logs/laravel.log
[2025-10-17 10:30:15] local.INFO: Chat context updated {"session_id":"chat_67890abc_1737100800","intent":"travel_planning","extracted_info":{"destination":"lisboa","people":2,"budget":800}}
```

### Métricas de Sessão
- Duração da conversa
- Número de mensagens
- Intenções detectadas
- Informações extraídas

O sistema agora é muito mais dinâmico e inteligente, oferecendo uma experiência de conversa natural e contextualizada!
