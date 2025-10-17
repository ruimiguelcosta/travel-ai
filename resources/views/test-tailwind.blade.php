@extends('layouts.app')

@section('title', 'Teste Tailwind CSS')

@section('content')
<div class="min-h-screen bg-background p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-foreground mb-8 gradient-text">
            Teste do Tailwind CSS
        </h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-card p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-card-foreground mb-4">Card 1</h2>
                <p class="text-muted-foreground mb-4">Este é um exemplo de card usando as cores personalizadas do Tailwind.</p>
                <button class="btn btn-primary">Botão Primário</button>
            </div>
            
            <div class="bg-card p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-card-foreground mb-4">Card 2</h2>
                <p class="text-muted-foreground mb-4">Outro exemplo de card com diferentes estilos.</p>
                <button class="btn btn-secondary">Botão Secundário</button>
            </div>
            
            <div class="bg-card p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-card-foreground mb-4">Card 3</h2>
                <p class="text-muted-foreground mb-4">Terceiro card para demonstrar o grid responsivo.</p>
                <div class="gradient-bg-light p-4 rounded-md">
                    <p class="text-sm">Área com fundo gradiente claro</p>
                </div>
            </div>
        </div>
        
        <div class="bg-card p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold text-card-foreground mb-4">Formulário de Exemplo</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-foreground mb-2">Nome</label>
                    <input type="text" class="w-full px-3 py-2 border border-input rounded-md focus:ring-2 focus:ring-ring focus:border-transparent" placeholder="Digite seu nome">
                </div>
                <div>
                    <label class="block text-sm font-medium text-foreground mb-2">Email</label>
                    <input type="email" class="w-full px-3 py-2 border border-input rounded-md focus:ring-2 focus:ring-ring focus:border-transparent" placeholder="Digite seu email">
                </div>
                <div>
                    <label class="block text-sm font-medium text-foreground mb-2">Mensagem</label>
                    <textarea class="w-full px-3 py-2 border border-input rounded-md focus:ring-2 focus:ring-ring focus:border-transparent" rows="4" placeholder="Digite sua mensagem"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
        
        <div class="bg-gradient-to-r from-primary to-secondary p-8 rounded-lg text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Gradiente Funcionando!</h2>
            <p class="text-white/90 text-lg">Se você está vendo este gradiente, o Tailwind CSS está funcionando perfeitamente!</p>
        </div>
    </div>
</div>
@endsection
