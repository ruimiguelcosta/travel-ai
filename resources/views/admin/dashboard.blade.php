@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-4xl font-bold mb-2 gradient-text">
            Dashboard
        </h1>
        <p class="text-muted-foreground">Bem-vindo de volta! Aqui está um resumo do seu negócio.</p>
    </div>

    <!-- Onboarding Card -->
    <div class="rounded-lg border border-primary/20 bg-gradient-to-r from-primary/5 to-secondary/5 bg-card text-card-foreground shadow-sm">
        <div class="flex flex-col space-y-1.5 p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">Complete sua configuração</h3>
                <span class="text-sm font-normal text-muted-foreground">
                    2/4 concluídos
                </span>
            </div>
            <p class="text-sm text-muted-foreground">
                Siga estes passos para aproveitar ao máximo a plataforma
            </p>
            <div class="relative h-4 w-full overflow-hidden rounded-full bg-secondary mt-4">
                <div class="h-full w-[50%] bg-primary transition-all"></div>
            </div>
        </div>
        <div class="p-6 pt-0 space-y-3">
            <div class="flex items-start gap-4 p-4 rounded-lg border transition-all cursor-pointer hover:border-primary/50 bg-accent/50 border-primary/30">
                <div class="mt-0.5 rounded-full p-1 bg-primary text-primary-foreground">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold">Configure seu perfil</h4>
                    <p class="text-sm text-muted-foreground">Adicione suas informações básicas</p>
                </div>
                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            <div class="flex items-start gap-4 p-4 rounded-lg border transition-all cursor-pointer hover:border-primary/50 bg-accent/50 border-primary/30">
                <div class="mt-0.5 rounded-full p-1 bg-primary text-primary-foreground">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold">Conecte integrações</h4>
                    <p class="text-sm text-muted-foreground">Vincule suas ferramentas favoritas</p>
                </div>
                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            <div class="flex items-start gap-4 p-4 rounded-lg border transition-all cursor-pointer hover:border-primary/50 bg-card">
                <div class="mt-0.5 rounded-full p-1 bg-muted">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold">Importe clientes</h4>
                    <p class="text-sm text-muted-foreground">Adicione sua base de clientes</p>
                </div>
                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            <div class="flex items-start gap-4 p-4 rounded-lg border transition-all cursor-pointer hover:border-primary/50 bg-card">
                <div class="mt-0.5 rounded-full p-1 bg-muted">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold">Configure orçamentos</h4>
                    <p class="text-sm text-muted-foreground">Defina modelos de orçamento</p>
                </div>
                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg hover:border-primary/30">
            <div class="flex flex-row items-center justify-between space-y-0 p-6 pb-2">
                <h3 class="tracking-tight text-sm font-medium text-muted-foreground">
                    Total de Clientes
                </h3>
                <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-3xl font-bold">1,248</div>
                <p class="text-xs text-green-600 mt-1">
                    +12.5% vs último mês
                </p>
            </div>
        </div>

        <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg hover:border-primary/30">
            <div class="flex flex-row items-center justify-between space-y-0 p-6 pb-2">
                <h3 class="tracking-tight text-sm font-medium text-muted-foreground">
                    Orçamentos Ativos
                </h3>
                <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-3xl font-bold">342</div>
                <p class="text-xs text-green-600 mt-1">
                    +8.2% vs último mês
                </p>
            </div>
        </div>

        <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg hover:border-primary/30">
            <div class="flex flex-row items-center justify-between space-y-0 p-6 pb-2">
                <h3 class="tracking-tight text-sm font-medium text-muted-foreground">
                    Receita Mensal
                </h3>
                <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-3xl font-bold">R$ 45.2K</div>
                <p class="text-xs text-green-600 mt-1">
                    +23.1% vs último mês
                </p>
            </div>
        </div>

        <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg hover:border-primary/30">
            <div class="flex flex-row items-center justify-between space-y-0 p-6 pb-2">
                <h3 class="tracking-tight text-sm font-medium text-muted-foreground">
                    Taxa de Conversão
                </h3>
                <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-3xl font-bold">68%</div>
                <p class="text-xs text-green-600 mt-1">
                    +5.4% vs último mês
                </p>
            </div>
        </div>
    </div>

    <!-- Bottom Cards -->
    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">Atividade Recente</h3>
                <p class="text-sm text-muted-foreground">Últimas ações no sistema</p>
            </div>
            <div class="p-6 pt-0">
                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-3 rounded-lg bg-muted/50">
                        <div class="h-2 w-2 rounded-full bg-primary"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">Novo orçamento criado</p>
                            <p class="text-xs text-muted-foreground">há 1 hora</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 rounded-lg bg-muted/50">
                        <div class="h-2 w-2 rounded-full bg-primary"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">Cliente atualizado</p>
                            <p class="text-xs text-muted-foreground">há 2 horas</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 rounded-lg bg-muted/50">
                        <div class="h-2 w-2 rounded-full bg-primary"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">Integração conectada</p>
                            <p class="text-xs text-muted-foreground">há 3 horas</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 rounded-lg bg-muted/50">
                        <div class="h-2 w-2 rounded-full bg-primary"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">Relatório gerado</p>
                            <p class="text-xs text-muted-foreground">há 4 horas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">Próximas Tarefas</h3>
                <p class="text-sm text-muted-foreground">Ações pendentes</p>
            </div>
            <div class="p-6 pt-0">
                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-3 rounded-lg bg-muted/50">
                        <div class="h-2 w-2 rounded-full bg-secondary"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">Revisar proposta #001</p>
                            <p class="text-xs text-muted-foreground">Vence amanhã</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 rounded-lg bg-muted/50">
                        <div class="h-2 w-2 rounded-full bg-secondary"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">Enviar orçamento #002</p>
                            <p class="text-xs text-muted-foreground">Vence em 2 dias</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 rounded-lg bg-muted/50">
                        <div class="h-2 w-2 rounded-full bg-secondary"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">Follow-up cliente ABC</p>
                            <p class="text-xs text-muted-foreground">Vence em 3 dias</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 rounded-lg bg-muted/50">
                        <div class="h-2 w-2 rounded-full bg-secondary"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">Atualizar integração</p>
                            <p class="text-xs text-muted-foreground">Vence em 1 semana</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
