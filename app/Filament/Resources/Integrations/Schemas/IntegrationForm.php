<?php

namespace App\Filament\Resources\Integrations\Schemas;

use App\Models\IntegrationCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class IntegrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Select::make('integration_category_id')
                            ->label('Categoria')
                            ->options(IntegrationCategory::query()->pluck('name', 'id'))
                            ->required()
                            ->searchable(),

                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                    ]),

                Grid::make(2)
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('base_url')
                            ->label('URL Base')
                            ->required()
                            ->url()
                            ->maxLength(255),
                    ]),

                Textarea::make('description')
                    ->label('Descrição')
                    ->rows(3)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Ativo')
                    ->default(true),
            ]);
    }
}
