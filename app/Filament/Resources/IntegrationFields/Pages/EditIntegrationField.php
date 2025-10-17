<?php

namespace App\Filament\Resources\IntegrationFields\Pages;

use App\Filament\Resources\IntegrationFields\IntegrationFieldResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIntegrationField extends EditRecord
{
    protected static string $resource = IntegrationFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
