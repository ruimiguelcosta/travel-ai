<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SalesReports extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.sales-reports';

    protected static ?string $title = 'Relatórios de Vendas';

    protected static ?string $navigationLabel = 'Relatórios';

    protected static ?int $navigationSort = 3;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('start_date')
                    ->label('Data Início')
                    ->displayFormat('d/m/Y'),
                DatePicker::make('end_date')
                    ->label('Data Fim')
                    ->displayFormat('d/m/Y'),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'completed' => 'Concluído',
                        'cancelled' => 'Cancelado',
                    ])
                    ->placeholder('Todos os status'),
                Select::make('payment_status')
                    ->label('Status Pagamento')
                    ->options([
                        'pending' => 'Pendente',
                        'paid' => 'Pago',
                        'failed' => 'Falhou',
                        'refunded' => 'Reembolsado',
                    ])
                    ->placeholder('Todos os status de pagamento'),
                Select::make('payment_method')
                    ->label('Método de Pagamento')
                    ->options([
                        'credit_card' => 'Cartão de Crédito',
                        'paypal' => 'PayPal',
                        'bank_transfer' => 'Transferência Bancária',
                        'cash' => 'Dinheiro',
                    ])
                    ->placeholder('Todos os métodos'),
                TextInput::make('customer_email')
                    ->label('Email do Cliente')
                    ->placeholder('Filtrar por email'),
                TextInput::make('product_name')
                    ->label('Nome do Produto')
                    ->placeholder('Filtrar por produto'),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('product_name')
                    ->label('Produto')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                    }),
                TextColumn::make('payment_status')
                    ->label('Pagamento')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        'refunded' => 'gray',
                    }),
                TextColumn::make('sale_date')
                    ->label('Data Venda')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('export_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->url(fn () => $this->getExportUrl('pdf'))
                    ->openUrlInNewTab(),
                Action::make('export_excel')
                    ->label('Excel')
                    ->icon('heroicon-o-table-cells')
                    ->color('success')
                    ->url(fn () => $this->getExportUrl('excel'))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('sale_date', 'desc');
    }

    protected function getTableQuery(): Builder
    {
        $filters = $this->data;
        $query = \App\Models\Sale::query();

        if (! empty($filters['start_date'])) {
            $query->where('sale_date', '>=', $filters['start_date']);
        }

        if (! empty($filters['end_date'])) {
            $query->where('sale_date', '<=', $filters['end_date']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (! empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        if (! empty($filters['customer_email'])) {
            $query->where('customer_email', 'like', '%'.$filters['customer_email'].'%');
        }

        if (! empty($filters['product_name'])) {
            $query->where('product_name', 'like', '%'.$filters['product_name'].'%');
        }

        return $query;
    }

    protected function getExportUrl(string $format): string
    {
        $filters = $this->data;
        $params = http_build_query(array_filter($filters));

        return route('api.sales-reports.export.'.$format).($params ? '?'.$params : '');
    }

    public function getTitle(): string
    {
        return 'Relatórios de Vendas';
    }
}
