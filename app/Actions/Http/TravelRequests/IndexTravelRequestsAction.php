<?php

namespace App\Actions\Http\TravelRequests;

use App\Models\TravelRequest;
use Illuminate\Http\JsonResponse;

class IndexTravelRequestsAction
{
    public function __invoke(): JsonResponse
    {
        $travelRequests = TravelRequest::query()
            ->latest()
            ->paginate(15);

        return response()->json($travelRequests);
    }
}
