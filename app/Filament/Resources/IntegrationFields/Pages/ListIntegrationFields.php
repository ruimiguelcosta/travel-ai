<?php

namespace App\Filament\Resources\IntegrationFields\Pages;

use App\Filament\Resources\IntegrationFields\IntegrationFieldResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIntegrationFields extends ListRecords
{
    protected static string $resource = IntegrationFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
