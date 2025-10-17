<?php

namespace App\Filament\Resources\Budgets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BudgetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client_name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('client_email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('client_company')
                    ->label('Empresa')
                    ->searchable()
                    ->toggleable(),

                BadgeColumn::make('client_type')
                    ->label('Tipo')
                    ->colors([
                        'warning' => 'potential',
                        'success' => 'client',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'potential' => 'Potencial',
                        'client' => 'Cliente',
                    }),

                TextColumn::make('total_amount')
                    ->label('Valor Total')
                    ->money('BRL')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'draft',
                        'info' => 'sent',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'warning' => 'expired',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Rascunho',
                        'sent' => 'Enviado',
                        'approved' => 'Aprovado',
                        'rejected' => 'Rejeitado',
                        'expired' => 'Expirado',
                    }),

                TextColumn::make('valid_until')
                    ->label('Válido Até')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('client_type')
                    ->label('Tipo de Cliente')
                    ->options([
                        'potential' => 'Potencial Cliente',
                        'client' => 'Cliente',
                    ]),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Rascunho',
                        'sent' => 'Enviado',
                        'approved' => 'Aprovado',
                        'rejected' => 'Rejeitado',
                        'expired' => 'Expirado',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
