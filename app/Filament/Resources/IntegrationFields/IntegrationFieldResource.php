<?php

namespace App\Filament\Resources\IntegrationFields;

use App\Filament\Resources\IntegrationFields\Pages\CreateIntegrationField;
use App\Filament\Resources\IntegrationFields\Pages\EditIntegrationField;
use App\Filament\Resources\IntegrationFields\Pages\ListIntegrationFields;
use App\Filament\Resources\IntegrationFields\Schemas\IntegrationFieldForm;
use App\Filament\Resources\IntegrationFields\Tables\IntegrationFieldsTable;
use App\Models\IntegrationField;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IntegrationFieldResource extends Resource
{
    protected static ?string $model = IntegrationField::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return IntegrationFieldForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IntegrationFieldsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIntegrationFields::route('/'),
            'create' => CreateIntegrationField::route('/create'),
            'edit' => EditIntegrationField::route('/{record}/edit'),
        ];
    }
}
