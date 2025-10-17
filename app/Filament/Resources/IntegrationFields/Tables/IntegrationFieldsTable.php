<?php

namespace App\Filament\Resources\IntegrationFields\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class IntegrationFieldsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('integration.name')
                    ->label('Integração')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nome do Campo')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('label')
                    ->label('Rótulo')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'text' => 'gray',
                        'email' => 'blue',
                        'password' => 'red',
                        'number' => 'green',
                        'url' => 'purple',
                        'tel' => 'orange',
                        'textarea' => 'indigo',
                        'select' => 'pink',
                        'checkbox' => 'yellow',
                        'radio' => 'cyan',
                        default => 'gray',
                    }),

                TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->sortable(),

                IconColumn::make('required')
                    ->label('Obrigatório')
                    ->boolean(),

                IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('integration_id')
                    ->label('Integração')
                    ->relationship('integration', 'name'),

                SelectFilter::make('type')
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
                    ]),

                SelectFilter::make('is_active')
                    ->label('Ativo')
                    ->options([
                        1 => 'Sim',
                        0 => 'Não',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('integration_id', 'asc')
            ->defaultSort('sort_order', 'asc');
    }
}
