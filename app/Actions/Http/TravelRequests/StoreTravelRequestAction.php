<?php

namespace App\Actions\Http\TravelRequests;

use App\Domain\TravelRequests\Data\TravelRequestData;
use App\Domain\TravelRequests\Services\TravelRequestService;
use App\Http\Requests\TravelRequests\StoreTravelRequestRequest;
use Illuminate\Http\JsonResponse;

class StoreTravelRequestAction
{
    public function __construct(private TravelRequestService $service) {}

    public function __invoke(StoreTravelRequestRequest $request): JsonResponse
    {
        $data = TravelRequestData::from($request->validated());
        $travelRequest = $this->service->create($data);

        $travelRequestWithResults = $this->service->initiateMarketSearchWithLLM($travelRequest);

        return response()->json([
            'message' => 'Solicitação de viagem criada com sucesso. Análise LLM em processamento.',
            'travel_request' => $travelRequestWithResults->toArray(),
        ], 201);
    }
}
