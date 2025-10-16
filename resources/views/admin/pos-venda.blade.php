@extends('layouts.admin')

@section('title', 'Pós-venda - Admin Panel')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-4xl font-bold mb-2 gradient-text">
            Pós-venda
        </h1>
        <p class="text-muted-foreground">
            Gerencie tickets de suporte e atendimento ao cliente
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid gap-6 md:grid-cols-3">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">3</h3>
                <p class="text-sm text-muted-foreground flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    Tickets Abertos
                </p>
            </div>
        </div>
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">2</h3>
                <p class="text-sm text-muted-foreground flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Em Andamento
                </p>
            </div>
        </div>
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">2</h3>
                <p class="text-sm text-muted-foreground flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Resolvidos Hoje
                </p>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="space-y-4">
        <div class="inline-flex h-10 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground">
            <button class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm bg-background text-foreground shadow-sm">
                Abertos
            </button>
            <button class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm">
                Em Andamento
            </button>
            <button class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm">
                Resolvidos
            </button>
        </div>

        <!-- Tickets Abertos -->
        <div class="space-y-3">
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex gap-3 flex-1">
                            <div class="h-10 w-10 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <p class="font-semibold">Empresa ABC</p>
                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-destructive text-destructive-foreground hover:bg-destructive/80">
                                        Alta
                                    </span>
                                </div>
                                <p class="text-sm text-muted-foreground">Dúvida sobre funcionalidade</p>
                                <p class="text-xs text-muted-foreground mt-1">há 2h</p>
                            </div>
                        </div>
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                            Ver ticket
                        </button>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex gap-3 flex-1">
                            <div class="h-10 w-10 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <p class="font-semibold">Startup XYZ</p>
                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-primary text-primary-foreground hover:bg-primary/80">
                                        Média
                                    </span>
                                </div>
                                <p class="text-sm text-muted-foreground">Solicitação de suporte técnico</p>
                                <p class="text-xs text-muted-foreground mt-1">há 5h</p>
                            </div>
                        </div>
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                            Ver ticket
                        </button>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex gap-3 flex-1">
                            <div class="h-10 w-10 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <p class="font-semibold">Tech Corp</p>
                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-destructive text-destructive-foreground hover:bg-destructive/80">
                                        Alta
                                    </span>
                                </div>
                                <p class="text-sm text-muted-foreground">Erro ao processar pagamento</p>
                                <p class="text-xs text-muted-foreground mt-1">há 1h</p>
                            </div>
                        </div>
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                            Ver ticket
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
