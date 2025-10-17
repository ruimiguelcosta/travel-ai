<?php

namespace App\Jobs;

use App\Domain\LLM\Data\LLMResponseData;
use App\Domain\LLM\Services\LLMService;
use App\Models\TravelRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessLLMRequestJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private TravelRequest $travelRequest,
        private string $driver = 'chatgpt',
        private array $context = [],
    ) {}

    public function handle(LLMService $llmService): void
    {
        try {
            $prompt = $this->buildTravelPrompt($this->travelRequest);

            $response = $llmService->generateResponse(
                $prompt,
                $this->driver,
                $this->context
            );

            $this->updateTravelRequestWithLLMResponse($response);

            Log::info('LLM Request processed successfully', [
                'travel_request_id' => $this->travelRequest->id,
                'driver' => $this->driver,
            ]);
        } catch (\Exception $e) {
            Log::error('LLM Request processing failed', [
                'travel_request_id' => $this->travelRequest->id,
                'driver' => $this->driver,
                'error' => $e->getMessage(),
            ]);

            $this->travelRequest->update([
                'status' => 'llm_error',
                'search_results' => array_merge(
                    $this->travelRequest->search_results ?? [],
                    ['llm_error' => $e->getMessage()]
                ),
            ]);
        }
    }

    private function buildTravelPrompt(TravelRequest $travelRequest): string
    {
        return "Analise esta solicitação de viagem e forneça recomendações detalhadas:

Destino: {$travelRequest->destination_city}, {$travelRequest->destination_country}
Datas: {$travelRequest->checkin_date->format('d/m/Y')} a {$travelRequest->checkout_date->format('d/m/Y')}
Pessoas: {$travelRequest->adults} adultos".
($travelRequest->children > 0 ? ", {$travelRequest->children} crianças" : '').'
Preferências: '.implode(', ', $travelRequest->preferences).'
Orçamento: '.($travelRequest->budget ? "€{$travelRequest->budget}" : 'Não especificado').'

Por favor, forneça:
1. Recomendações de hotéis específicos
2. Atividades turísticas recomendadas
3. Dicas de transporte local
4. Estimativa de custos detalhada
5. Sugestões personalizadas baseadas nas preferências';
    }

    private function updateTravelRequestWithLLMResponse(LLMResponseData $response): void
    {
        $currentResults = $this->travelRequest->search_results ?? [];

        $this->travelRequest->update([
            'search_results' => array_merge($currentResults, [
                'llm_recommendations' => $response->content,
                'llm_driver' => $response->driver,
                'llm_metadata' => $response->metadata,
                'llm_processed_at' => now()->toISOString(),
            ]),
            'status' => 'llm_processed',
        ]);
    }
}
