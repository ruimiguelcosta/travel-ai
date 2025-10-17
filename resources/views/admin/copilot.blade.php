@extends('layouts.admin')

@section('title', 'AI Copilot - Admin Panel')

@section('content')
<div class="grid grid-cols-4 gap-6 h-[calc(100vh-4rem)]">
    <!-- Chat Area -->
    <div class="col-span-3 bg-white rounded-lg border shadow-sm">
        <div class="p-6 border-b">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Chat com IA</h3>
                    <p class="text-sm text-muted-foreground">
                        Preencha o template de viagem para criar o seu pacote personalizado
                    </p>
                </div>
                <button id="new-chat-btn" class="px-4 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors">
                    <svg class="h-4 w-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Novo Chat
                </button>
            </div>
        </div>
        
        <div class="flex-1 p-6 overflow-y-auto" id="chat-container">
            <div class="space-y-4" id="chat-messages">
                <div class="flex gap-3 justify-start">
                    <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                        <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="max-w-[40%] rounded-2xl px-4 py-3 bg-muted">
                        <p class="text-sm" id="greeting-message">Carregando...</p>
                        <p class="text-xs opacity-60 mt-1" id="greeting-time"></p>
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
    
    <!-- Template Visual -->
    <div class="col-span-1 bg-white rounded-lg border shadow-sm">
        <div class="p-6 border-b">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold leading-none tracking-tight">Template de Viagem</h3>
                    <p class="text-sm text-muted-foreground">
                        Informações coletadas
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-primary" id="completion-percentage">0%</div>
                    <div class="text-xs text-muted-foreground">Completo</div>
                </div>
            </div>
        </div>
        
        <div class="p-6 overflow-y-auto">
            <div class="space-y-4" id="template-fields">
                <!-- Template fields will be populated here -->
            </div>
        </div>
    </div>
</div>

<script>
// ... (rest of the script remains the same)
</script>
@endsection