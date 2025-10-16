@extends('layouts.admin')

@section('title', 'Clientes - Admin Panel')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold mb-2 gradient-text">
                Clientes
            </h1>
            <p class="text-muted-foreground">
                Gerencie sua base de clientes e contatos
            </p>
        </div>
        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 bg-gradient-to-r from-primary to-secondary text-primary-foreground hover:opacity-90">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Novo Cliente
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid gap-6 md:grid-cols-4">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">4</h3>
                <p class="text-sm text-muted-foreground">Total de Clientes</p>
            </div>
        </div>
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">3</h3>
                <p class="text-sm text-muted-foreground">Clientes Ativos</p>
            </div>
        </div>
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">R$ 163.8K</h3>
                <p class="text-sm text-muted-foreground">Valor Total</p>
            </div>
        </div>
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">R$ 40.9K</h3>
                <p class="text-sm text-muted-foreground">Ticket Médio</p>
            </div>
        </div>
    </div>

    <!-- Clientes List -->
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="flex flex-col space-y-1.5 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Lista de Clientes</h3>
                    <p class="text-sm text-muted-foreground">Todos os seus clientes cadastrados</p>
                </div>
                <div class="relative w-64">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input placeholder="Buscar clientes..." class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm pl-9">
                </div>
            </div>
        </div>
        <div class="p-6 pt-0">
            <div class="space-y-4">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-all cursor-pointer">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-4 flex-1">
                                <div class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-primary/20">
                                    <div class="flex h-full w-full items-center justify-center rounded-full bg-gradient-to-br from-primary to-secondary text-white font-semibold">
                                        JS
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="font-semibold text-lg">João Silva</h3>
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-primary text-primary-foreground hover:bg-primary/80">
                                            ativo
                                        </span>
                                    </div>
                                    <p class="text-sm text-muted-foreground font-medium mb-3">Empresa ABC</p>
                                    <div class="flex flex-wrap gap-4 text-sm text-muted-foreground">
                                        <div class="flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            joao@empresaabc.com
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            (11) 98765-4321
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-primary mb-2">R$ 45.2K</p>
                                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                                    Ver perfil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-all cursor-pointer">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-4 flex-1">
                                <div class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-primary/20">
                                    <div class="flex h-full w-full items-center justify-center rounded-full bg-gradient-to-br from-primary to-secondary text-white font-semibold">
                                        MS
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="font-semibold text-lg">Maria Santos</h3>
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-primary text-primary-foreground hover:bg-primary/80">
                                            ativo
                                        </span>
                                    </div>
                                    <p class="text-sm text-muted-foreground font-medium mb-3">Startup XYZ</p>
                                    <div class="flex flex-wrap gap-4 text-sm text-muted-foreground">
                                        <div class="flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            maria@startupxyz.com
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            (21) 99876-5432
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-primary mb-2">R$ 32.8K</p>
                                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                                    Ver perfil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-all cursor-pointer">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-4 flex-1">
                                <div class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-primary/20">
                                    <div class="flex h-full w-full items-center justify-center rounded-full bg-gradient-to-br from-primary to-secondary text-white font-semibold">
                                        PC
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="font-semibold text-lg">Pedro Costa</h3>
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80">
                                            inativo
                                        </span>
                                    </div>
                                    <p class="text-sm text-muted-foreground font-medium mb-3">Tech Corp</p>
                                    <div class="flex flex-wrap gap-4 text-sm text-muted-foreground">
                                        <div class="flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            pedro@techcorp.com
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            (11) 97654-3210
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-primary mb-2">R$ 18.5K</p>
                                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                                    Ver perfil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-all cursor-pointer">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-4 flex-1">
                                <div class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-primary/20">
                                    <div class="flex h-full w-full items-center justify-center rounded-full bg-gradient-to-br from-primary to-secondary text-white font-semibold">
                                        AO
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="font-semibold text-lg">Ana Oliveira</h3>
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-primary text-primary-foreground hover:bg-primary/80">
                                            ativo
                                        </span>
                                    </div>
                                    <p class="text-sm text-muted-foreground font-medium mb-3">Digital Solutions</p>
                                    <div class="flex flex-wrap gap-4 text-sm text-muted-foreground">
                                        <div class="flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            ana@digitalsolutions.com
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            (31) 98765-1234
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-primary mb-2">R$ 67.3K</p>
                                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                                    Ver perfil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
