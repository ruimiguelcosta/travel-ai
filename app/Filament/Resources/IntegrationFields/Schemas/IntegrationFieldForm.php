<?php

namespace App\Filament\Resources\IntegrationFields\Schemas;

use App\Models\Integration;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class IntegrationFieldForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Select::make('integration_id')
                            ->label('Integração')
                            ->options(Integration::query()->pluck('name', 'id'))
                            ->required()
                            ->searchable(),

                        TextInput::make('name')
                            ->label('Nome do Campo')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Nome técnico do campo (ex: api_key, username)'),
                    ]),

                Grid::make(2)
                    ->schema([
                        TextInput::make('label')
                            ->label('Rótulo')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Rótulo exibido ao utilizador'),

                        Select::make('type')
                            ->label('Tipo')
                            ->options([
                                'text' => 'Texto',
                                'email' => 'Email',
                                'password' => 'Password',
                                'number' => 'Número',
                                'url' => 'URL',
                                'tel' => 'Telefone',
                                'textarea' => 'Área de Texto',
                                'select' => 'Seleção',
                                'checkbox' => 'Checkbox',
                                'radio' => 'Radio',
                            ])
                            ->required()
                            ->default('text'),
                    ]),

                Grid::make(2)
                    ->schema([
                        TextInput::make('placeholder')
                            ->label('Placeholder')
                            ->maxLength(255),

                        TextInput::make('sort_order')
                            ->label('Ordem')
                            ->numeric()
                            ->default(0),
                    ]),

                Textarea::make('help_text')
                    ->label('Texto de Ajuda')
                    ->rows(2)
                    ->columnSpanFull(),

                Repeater::make('options')
                    ->label('Opções (para select/radio)')
                    ->schema([
                        TextInput::make('value')
                            ->label('Valor')
                            ->required(),
                        TextInput::make('label')
                            ->label('Rótulo')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn ($get) => in_array($get('type'), ['select', 'radio'])),

                Grid::make(2)
                    ->schema([
                        Toggle::make('required')
                            ->label('Obrigatório')
                            ->default(false),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),
                    ]),
            ]);
    }
}
