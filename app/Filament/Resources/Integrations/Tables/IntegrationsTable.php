<?php

namespace App\Filament\Resources\Integrations\Tables;

use App\Filament\Resources\Integrations\Actions\ConfigureIntegrationAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class IntegrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('base_url')
                    ->label('URL Base')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        return strlen($state) > 50 ? $state : null;
                    }),

                TextColumn::make('fields_count')
                    ->label('Campos')
                    ->counts('fields')
                    ->badge(),

                IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('integration_category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name'),

                SelectFilter::make('is_active')
                    ->label('Ativo')
                    ->options([
                        1 => 'Sim',
                        0 => 'Não',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                ConfigureIntegrationAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }
}
