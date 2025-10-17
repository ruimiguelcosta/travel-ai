<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Filtros de Relatório</h2>
            {{ $this->form }}
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Dados das Vendas</h2>
                <p class="text-sm text-gray-600 mt-1">Use os filtros acima para personalizar o relatório</p>
            </div>
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>