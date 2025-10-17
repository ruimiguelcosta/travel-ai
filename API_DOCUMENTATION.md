# API de Solicitações de Viagem

Esta API permite criar e listar solicitações de viagem com análise automática de mercado.

## Endpoints

### POST /api/travel-requests

Cria uma nova solicitação de viagem e executa automaticamente a análise de mercado.

**Payload:**
```json
{
    "name": "João Silva",
    "email": "joao@example.com",
    "phone": "+351912345678",
    "checkin_date": "2024-12-01",
    "checkout_date": "2024-12-07",
    "destination_country": "Portugal",
    "destination_city": "Lisboa",
    "preferences": ["beach", "culture", "food"],
    "adults": 2,
    "children": 1,
    "budget": 1500.00
}
```

**Resposta:**
```json
{
    "message": "Solicitação de viagem criada com sucesso",
    "travel_request": {
        "id": 1,
        "name": "João Silva",
        "email": "joao@example.com",
        "phone": "+351912345678",
        "checkin_date": "2024-12-01",
        "checkout_date": "2024-12-07",
        "destination_country": "Portugal",
        "destination_city": "Lisboa",
        "preferences": ["beach", "culture", "food"],
        "adults": 2,
        "children": 1,
        "budget": 1500.00,
        "status": "completed",
        "search_results": {
            "hotels": [
                {
                    "name": "Hotel Example 1",
                    "price_per_night": 150.00,
                    "rating": 4.5,
                    "amenities": ["WiFi", "Pool", "Gym"],
                    "location": "Lisboa"
                }
            ],
            "car_rentals": [
                {
                    "company": "Rent-a-Car Example",
                    "car_type": "Economy",
                    "price_per_day": 45.00,
                    "features": ["Air Conditioning", "GPS"]
                }
            ],
            "activities": [
                {
                    "name": "City Tour",
                    "type": "Sightseeing",
                    "price": 50.00,
                    "duration": "4 hours",
                    "description": "Guided tour of the main attractions"
                }
            ],
            "total_estimated_cost": 1205.00
        },
        "created_at": "2024-10-17T08:30:00.000000Z",
        "updated_at": "2024-10-17T08:30:00.000000Z"
    }
}
```

### GET /api/travel-requests

Lista todas as solicitações de viagem com paginação.

**Resposta:**
```json
{
    "data": [
        {
            "id": 1,
            "name": "João Silva",
            "email": "joao@example.com",
            "status": "completed",
            "destination_city": "Lisboa",
            "checkin_date": "2024-12-01",
            "checkout_date": "2024-12-07",
            "total_estimated_cost": 1205.00
        }
    ],
    "links": {
        "first": "http://aitravel.test/api/travel-requests?page=1",
        "last": "http://aitravel.test/api/travel-requests?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```

## Validações

- **name**: Obrigatório, string, máximo 255 caracteres
- **email**: Obrigatório, formato de email válido, máximo 255 caracteres
- **phone**: Obrigatório, string, máximo 20 caracteres
- **checkin_date**: Obrigatório, data, deve ser posterior a hoje
- **checkout_date**: Obrigatório, data, deve ser posterior à data de check-in
- **destination_country**: Obrigatório, string, máximo 100 caracteres
- **destination_city**: Obrigatório, string, máximo 100 caracteres
- **preferences**: Obrigatório, array de strings, máximo 100 caracteres cada
- **adults**: Obrigatório, inteiro entre 1 e 10
- **children**: Opcional, inteiro entre 0 e 10
- **budget**: Opcional, número positivo

## Funcionalidades

1. **Validação Completa**: Todos os campos são validados antes do processamento
2. **Análise Automática de Mercado**: Após criar a solicitação, o sistema automaticamente:
   - Procura hotéis no destino
   - Procura opções de aluguer de carros
   - Procura atividades turísticas
   - Calcula o custo total estimado
3. **Status Tracking**: Cada solicitação tem um status (pending → completed)
4. **Paginação**: Lista de solicitações com paginação automática

## Exemplo de Uso com cURL

```bash
curl -X POST http://aitravel.test/api/travel-requests \
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
