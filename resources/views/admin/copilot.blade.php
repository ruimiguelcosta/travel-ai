@extends('layouts.admin')

@section('title', 'AI Copilot - Admin Panel')

@section('content')
<div class="h-[calc(100vh-8rem)]">
    <div class="mb-4">
        <h1 class="text-4xl font-bold mb-2 gradient-text">
            AI Copilot
        </h1>
        <p class="text-muted-foreground">
            Seu assistente inteligente para otimizar tarefas e obter insights
        </p>
    </div>

    <div class="rounded-lg border bg-card text-card-foreground shadow-sm h-[calc(100%-6rem)] flex flex-col">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="text-2xl font-semibold leading-none tracking-tight">Chat com IA</h3>
            <p class="text-sm text-muted-foreground">
                Faça perguntas sobre seus dados, gere relatórios ou solicite análises
            </p>
        </div>
        <div class="flex-1 flex flex-col p-0">
            <div class="flex-1 p-6 overflow-auto">
                <div class="space-y-4">
                    <div class="flex gap-3 justify-start">
                        <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="max-w-[80%] rounded-2xl px-4 py-3 bg-muted">
                            <p class="text-sm">Olá! Sou seu assistente AI. Como posso ajudar você hoje?</p>
                            <p class="text-xs opacity-60 mt-1">14:30</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 justify-end">
                        <div class="max-w-[80%] rounded-2xl px-4 py-3 bg-primary text-primary-foreground">
                            <p class="text-sm">Como posso gerar um relatório de vendas?</p>
                            <p class="text-xs opacity-60 mt-1">14:32</p>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-secondary/10 flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 justify-start">
                        <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="max-w-[80%] rounded-2xl px-4 py-3 bg-muted">
                            <p class="text-sm">Para gerar um relatório de vendas, você pode:</p>
                            <ul class="text-sm mt-2 space-y-1">
                                <li>• Acessar a seção "Relatórios" no menu</li>
                                <li>• Selecionar o período desejado</li>
                                <li>• Escolher os filtros apropriados</li>
                                <li>• Exportar em PDF ou Excel</li>
                            </ul>
                            <p class="text-xs opacity-60 mt-1">14:33</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 justify-end">
                        <div class="max-w-[80%] rounded-2xl px-4 py-3 bg-primary text-primary-foreground">
                            <p class="text-sm">Qual é o melhor horário para enviar propostas?</p>
                            <p class="text-xs opacity-60 mt-1">14:35</p>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-secondary/10 flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 justify-start">
                        <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="max-w-[80%] rounded-2xl px-4 py-3 bg-muted">
                            <p class="text-sm">Baseado nos dados históricos da sua empresa, o melhor horário para enviar propostas é:</p>
                            <ul class="text-sm mt-2 space-y-1">
                                <li>• <strong>Terças e quartas-feiras</strong> entre 10h e 14h</li>
                                <li>• <strong>Taxa de resposta 23% maior</strong> neste período</li>
                                <li>• Evitar sextas-feiras após 15h</li>
                                <li>• Segundas-feiras têm menor engajamento</li>
                            </ul>
                            <p class="text-xs opacity-60 mt-1">14:36</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t p-4">
                <form class="flex gap-2">
                    <input
                        type="text"
                        placeholder="Digite sua mensagem..."
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                    />
                    <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 w-10">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
