<?php

namespace App\Domain\TravelRequests\Services;

use App\Domain\TravelRequests\Data\TravelRequestData;
use App\Jobs\ProcessLLMRequestJob;
use App\Models\TravelRequest;
use Illuminate\Support\Facades\DB;

class TravelRequestService
{
    public function create(TravelRequestData $data): TravelRequest
    {
        return DB::transaction(function () use ($data) {
            return TravelRequest::query()->create([
                'name' => $data->name,
                'email' => $data->email,
                'phone' => $data->phone,
                'checkin_date' => $data->checkinDate,
                'checkout_date' => $data->checkoutDate,
                'destination_country' => $data->destinationCountry,
                'destination_city' => $data->destinationCity,
                'preferences' => $data->preferences,
                'adults' => $data->adults,
                'children' => $data->children,
                'budget' => $data->budget,
                'status' => 'pending',
            ]);
        });
    }

    public function initiateMarketSearch(TravelRequest $travelRequest): TravelRequest
    {
        $searchResults = $this->performMarketSearch($travelRequest);

        $travelRequest->update([
            'search_results' => $searchResults,
            'status' => 'completed',
        ]);

        return $travelRequest;
    }

    public function initiateLLMAnalysis(TravelRequest $travelRequest, string $driver = 'chatgpt'): void
    {
        ProcessLLMRequestJob::dispatch($travelRequest, $driver);
    }

    public function initiateMarketSearchWithLLM(TravelRequest $travelRequest, string $driver = 'chatgpt'): TravelRequest
    {
        $searchResults = $this->performMarketSearch($travelRequest);

        $travelRequest->update([
            'search_results' => $searchResults,
            'status' => 'completed',
        ]);

        $this->initiateLLMAnalysis($travelRequest, $driver);

        return $travelRequest;
    }

    private function performMarketSearch(TravelRequest $travelRequest): array
    {
        return [
            'hotels' => $this->searchHotels($travelRequest),
            'car_rentals' => $this->searchCarRentals($travelRequest),
            'activities' => $this->searchActivities($travelRequest),
            'total_estimated_cost' => $this->calculateTotalCost($travelRequest),
        ];
    }

    private function searchHotels(TravelRequest $travelRequest): array
    {
        return [
            [
                'name' => 'Hotel Example 1',
                'price_per_night' => 150.00,
                'rating' => 4.5,
                'amenities' => ['WiFi', 'Pool', 'Gym'],
                'location' => $travelRequest->destination_city,
            ],
            [
                'name' => 'Hotel Example 2',
                'price_per_night' => 200.00,
                'rating' => 4.8,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant'],
                'location' => $travelRequest->destination_city,
            ],
        ];
    }

    private function searchCarRentals(TravelRequest $travelRequest): array
    {
        return [
            [
                'company' => 'Rent-a-Car Example',
                'car_type' => 'Economy',
                'price_per_day' => 45.00,
                'features' => ['Air Conditioning', 'GPS'],
            ],
            [
                'company' => 'Premium Cars',
                'car_type' => 'Luxury',
                'price_per_day' => 120.00,
                'features' => ['Air Conditioning', 'GPS', 'Leather Seats'],
            ],
        ];
    }

    private function searchActivities(TravelRequest $travelRequest): array
    {
        return [
            [
                'name' => 'City Tour',
                'type' => 'Sightseeing',
                'price' => 50.00,
                'duration' => '4 hours',
                'description' => 'Guided tour of the main attractions',
            ],
            [
                'name' => 'Adventure Park',
                'type' => 'Adventure',
                'price' => 80.00,
                'duration' => 'Full day',
                'description' => 'Thrilling activities and outdoor fun',
            ],
        ];
    }

    private function calculateTotalCost(TravelRequest $travelRequest): float
    {
        $nights = $travelRequest->checkin_date->diffInDays($travelRequest->checkout_date);
        $hotelCost = 150.00 * $nights;
        $carCost = 45.00 * $nights;
        $activityCost = 130.00;

        return $hotelCost + $carCost + $activityCost;
    }
}
