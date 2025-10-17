<?php

namespace Tests\Feature;

use App\Models\TravelRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_travel_request(): void
    {
        $payload = [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'phone' => '+351912345678',
            'checkin_date' => now()->addDays(30)->format('Y-m-d'),
            'checkout_date' => now()->addDays(37)->format('Y-m-d'),
            'destination_country' => 'Portugal',
            'destination_city' => 'Lisboa',
            'preferences' => ['beach', 'culture', 'food'],
            'adults' => 2,
            'children' => 1,
            'budget' => 1500.00,
        ];

        $response = $this->postJson('/api/travel-requests', $payload);

        $response->assertCreated()
            ->assertJsonPath('message', 'Solicitação de viagem criada com sucesso. Análise LLM em processamento.')
            ->assertJsonPath('travel_request.name', 'João Silva')
            ->assertJsonPath('travel_request.email', 'joao@example.com')
            ->assertJsonPath('travel_request.status', 'completed');

        $this->assertDatabaseHas('travel_requests', [
            'email' => 'joao@example.com',
        ]);
    }

    public function test_can_list_travel_requests(): void
    {
        TravelRequest::factory()->count(3)->create();

        $response = $this->getJson('/api/travel-requests');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'checkin_date',
                        'checkout_date',
                        'destination_country',
                        'destination_city',
                        'preferences',
                        'adults',
                        'children',
                        'budget',
                        'status',
                        'search_results',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    public function test_validates_required_fields(): void
    {
        $response = $this->postJson('/api/travel-requests', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'email',
                'phone',
                'checkin_date',
                'checkout_date',
                'destination_country',
                'destination_city',
                'preferences',
                'adults',
            ]);
    }

    public function test_validates_email_format(): void
    {
        $payload = [
            'name' => 'João Silva',
            'email' => 'invalid-email',
            'phone' => '+351912345678',
            'checkin_date' => now()->addDays(30)->format('Y-m-d'),
            'checkout_date' => now()->addDays(37)->format('Y-m-d'),
            'destination_country' => 'Portugal',
            'destination_city' => 'Lisboa',
            'preferences' => ['beach'],
            'adults' => 2,
        ];

        $response = $this->postJson('/api/travel-requests', $payload);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }

    public function test_validates_checkout_date_after_checkin_date(): void
    {
        $payload = [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'phone' => '+351912345678',
            'checkin_date' => now()->addDays(37)->format('Y-m-d'),
            'checkout_date' => now()->addDays(30)->format('Y-m-d'),
            'destination_country' => 'Portugal',
            'destination_city' => 'Lisboa',
            'preferences' => ['beach'],
            'adults' => 2,
        ];

        $response = $this->postJson('/api/travel-requests', $payload);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['checkout_date']);
    }

    public function test_includes_search_results_in_response(): void
    {
        $payload = [
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'phone' => '+351912345679',
            'checkin_date' => now()->addDays(30)->format('Y-m-d'),
            'checkout_date' => now()->addDays(37)->format('Y-m-d'),
            'destination_country' => 'Espanha',
            'destination_city' => 'Madrid',
            'preferences' => ['culture', 'food'],
            'adults' => 1,
            'children' => 0,
            'budget' => 800.00,
        ];

        $response = $this->postJson('/api/travel-requests', $payload);

        $response->assertCreated()
            ->assertJsonStructure([
                'travel_request' => [
                    'search_results' => [
                        'hotels',
                        'car_rentals',
                        'activities',
                        'total_estimated_cost',
                    ],
                ],
            ]);
    }
}
