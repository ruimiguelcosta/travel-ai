@extends('layouts.admin')

@section('title', 'Integrações - Admin Panel')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-4xl font-bold mb-2 gradient-text">
            Integrações
        </h1>
        <p class="text-muted-foreground">
            Conecte suas ferramentas favoritas para automatizar processos
        </p>
    </div>

    <!-- Comunicação -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">Comunicação</h2>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg border-primary/50 bg-primary/5">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">💬</div>
                            <div>
                                <h3 class="text-lg font-semibold leading-none tracking-tight">WhatsApp Business</h3>
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80 mt-1">
                                    Desconectado
                                </span>
                            </div>
                        </div>
                        <label class="peer inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input">
                            <input type="checkbox" class="sr-only">
                            <span class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span>
                        </label>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <p class="text-sm text-muted-foreground">Conecte sua conta do WhatsApp</p>
                    <button class="w-full mt-4 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        Conectar
                    </button>
                </div>
            </div>

            <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg border-primary/50 bg-primary/5">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">📧</div>
                            <div>
                                <h3 class="text-lg font-semibold leading-none tracking-tight">Gmail</h3>
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-primary text-primary-foreground hover:bg-primary/80 mt-1">
                                    Conectado
                                </span>
                            </div>
                        </div>
                        <label class="peer inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input">
                            <input type="checkbox" checked class="sr-only">
                            <span class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span>
                        </label>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <p class="text-sm text-muted-foreground">Sincronize seus emails</p>
                    <button class="w-full mt-4 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        Configurar
                    </button>
                </div>
            </div>

            <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">💼</div>
                            <div>
                                <h3 class="text-lg font-semibold leading-none tracking-tight">Slack</h3>
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80 mt-1">
                                    Desconectado
                                </span>
                            </div>
                        </div>
                        <label class="peer inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input">
                            <input type="checkbox" class="sr-only">
                            <span class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span>
                        </label>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <p class="text-sm text-muted-foreground">Notificações em tempo real</p>
                    <button class="w-full mt-4 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        Conectar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagamentos -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">Pagamentos</h2>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg border-primary/50 bg-primary/5">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">💳</div>
                            <div>
                                <h3 class="text-lg font-semibold leading-none tracking-tight">Stripe</h3>
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-primary text-primary-foreground hover:bg-primary/80 mt-1">
                                    Conectado
                                </span>
                            </div>
                        </div>
                        <label class="peer inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input">
                            <input type="checkbox" checked class="sr-only">
                            <span class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span>
                        </label>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <p class="text-sm text-muted-foreground">Processe pagamentos</p>
                    <button class="w-full mt-4 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        Configurar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Produtividade -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">Produtividade</h2>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">📅</div>
                            <div>
                                <h3 class="text-lg font-semibold leading-none tracking-tight">Google Calendar</h3>
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80 mt-1">
                                    Desconectado
                                </span>
                            </div>
                        </div>
                        <label class="peer inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input">
                            <input type="checkbox" class="sr-only">
                            <span class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span>
                        </label>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <p class="text-sm text-muted-foreground">Sincronize agendamentos</p>
                    <button class="w-full mt-4 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        Conectar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Automação -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">Automação</h2>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">⚡</div>
                            <div>
                                <h3 class="text-lg font-semibold leading-none tracking-tight">Zapier</h3>
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80 mt-1">
                                    Desconectado
                                </span>
                            </div>
                        </div>
                        <label class="peer inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input">
                            <input type="checkbox" class="sr-only">
                            <span class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span>
                        </label>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <p class="text-sm text-muted-foreground">Automatize fluxos de trabalho</p>
                    <button class="w-full mt-4 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        Conectar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
