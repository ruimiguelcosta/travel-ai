# Sistema de Chat Simplificado

## Funcionalidades

### ✅ **Saudação Baseada na Hora e Idioma**
- **Manhã**: "Bom dia!" / "Good morning!" / "Buenos días!"
- **Tarde**: "Boa tarde!" / "Good afternoon!" / "Buenas tardes!"
- **Noite**: "Boa noite!" / "Good evening!" / "Buenas noches!"

### ✅ **Detecção Automática de Idioma**
- Detecta idioma do browser (`Accept-Language`)
- Suporta: Português, Inglês, Espanhol, Francês, Alemão, Italiano
- Responde sempre no idioma detectado

### ✅ **Respostas Simples e Diretas**
- Sem contexto complexo
- Sem sugestões automáticas
- Respostas claras e práticas

## Exemplo de Uso

### 1. Inicializar Chat

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
  "metadata": {
    "time_of_day": "morning"
  }
}
```

### 2. Enviar Mensagem

```bash
curl -X POST http://127.0.0.1:8000/api/chat/message \
  -H "Content-Type: application/json" \
  -d '{
    "message": "Quero planear uma viagem para Lisboa",
    "language": "pt",
    "session_id": "chat_67890abc_1737100800"
  }'
```

**Resposta:**
```json
{
  "message": "Excelente escolha! Lisboa é uma cidade maravilhosa. Para te ajudar melhor com o planeamento da tua viagem, preciso de algumas informações:\n\n• Quando planeias viajar?\n• Quantas pessoas vão?\n• Qual o teu orçamento aproximado?\n• Que tipo de experiências procuras (culturais, gastronómicas, aventura)?\n\nCom estas informações posso dar-te recomendações mais específicas.",
  "language": "pt",
  "session_id": "chat_67890abc_1737100800",
  "type": "response",
  "metadata": {
    "llm_driver": "chatgpt",
    "processed_at": "2025-10-17T10:30:15.000000Z"
  }
}
```

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
  "session_id": "session_id_opcional"
}
```

## Configuração

### Variáveis de Ambiente
```env
# OpenAI Configuration
OPENAI_API_KEY=your_openai_api_key_here
OPENAI_MODEL=gpt-3.5-turbo
OPENAI_MAX_TOKENS=1000
```

## Características do Sistema Simplificado

### 🎯 **Foco na Simplicidade**
- Apenas saudação + resposta direta
- Sem contexto complexo
- Sem sugestões automáticas
- Respostas claras e práticas

### 🌍 **Multilíngue**
- Detecta idioma do browser
- Responde no idioma correto
- Suporta 6 idiomas principais

### ⚡ **Respostas Rápidas**
- Sem processamento de contexto
- Respostas diretas do LLM
- Foco na pergunta específica

### 🔧 **Fácil de Manter**
- Código simples e limpo
- Menos dependências
- Mais fácil de debugar

O sistema agora é **simples, direto e eficiente** - exatamente como pediste! 🚀
