<?php

namespace App\Domain\TravelRequests\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class TravelRequestData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        #[MapInputName('checkin_date')]
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public Carbon $checkinDate,
        #[MapInputName('checkout_date')]
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public Carbon $checkoutDate,
        #[MapInputName('destination_country')]
        public string $destinationCountry,
        #[MapInputName('destination_city')]
        public string $destinationCity,
        public array $preferences,
        public int $adults,
        public int $children,
        public ?float $budget,
    ) {}
}
