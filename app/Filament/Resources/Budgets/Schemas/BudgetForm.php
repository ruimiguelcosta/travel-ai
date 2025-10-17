<?php

namespace App\Filament\Resources\Budgets\Schemas;

use Filament\Schemas\Components\DatePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\KeyValue;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;

class BudgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do Cliente')
                    ->description('Dados do cliente ou potencial cliente')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('client_name')
                                    ->label('Nome do Cliente')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('client_email')
                                    ->label('Email do Cliente')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('client_phone')
                                    ->label('Telefone')
                                    ->tel()
                                    ->maxLength(20),

                                TextInput::make('client_company')
                                    ->label('Empresa')
                                    ->maxLength(255),
                            ]),

                        Select::make('client_type')
                            ->label('Tipo de Cliente')
                            ->options([
                                'potential' => 'Potencial Cliente',
                                'client' => 'Cliente',
                            ])
                            ->required()
                            ->default('potential'),
                    ]),

                Section::make('Detalhes do Orçamento')
                    ->description('Informações sobre o serviço e valores')
                    ->schema([
                        Textarea::make('service_description')
                            ->label('Descrição do Serviço')
                            ->required()
                            ->maxLength(1000)
                            ->rows(3),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('amount')
                                    ->label('Valor Base')
                                    ->numeric()
                                    ->required()
                                    ->prefix('R$')
                                    ->step(0.01),

                                TextInput::make('tax_amount')
                                    ->label('Impostos')
                                    ->numeric()
                                    ->prefix('R$')
                                    ->step(0.01),

                                TextInput::make('total_amount')
                                    ->label('Valor Total')
                                    ->numeric()
                                    ->required()
                                    ->prefix('R$')
                                    ->step(0.01),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('currency')
                                    ->label('Moeda')
                                    ->options([
                                        'BRL' => 'Real Brasileiro (BRL)',
                                        'USD' => 'Dólar Americano (USD)',
                                        'EUR' => 'Euro (EUR)',
                                    ])
                                    ->required()
                                    ->default('BRL'),

                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'draft' => 'Rascunho',
                                        'sent' => 'Enviado',
                                        'approved' => 'Aprovado',
                                        'rejected' => 'Rejeitado',
                                        'expired' => 'Expirado',
                                    ])
                                    ->required()
                                    ->default('draft'),
                            ]),

                        DatePicker::make('valid_until')
                            ->label('Válido Até')
                            ->after('today'),
                    ]),

                Section::make('Metadados')
                    ->description('Informações adicionais')
                    ->schema([
                        KeyValue::make('metadata')
                            ->label('Metadados')
                            ->keyLabel('Chave')
                            ->valueLabel('Valor')
                            ->addActionLabel('Adicionar Item'),
                    ])
                    ->collapsible(),
            ]);
    }
}
