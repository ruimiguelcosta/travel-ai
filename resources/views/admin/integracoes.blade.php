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

    @foreach($integrationCategories as $category)
    <div>
        <h2 class="text-2xl font-semibold mb-4">{{ $category->name }}</h2>
        <p class="text-sm text-muted-foreground mb-4">{{ $category->description }}</p>
        
        @if($category->integrations->count() > 0)
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($category->integrations as $integration)
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg {{ $integration->is_active ? 'border-primary/50 bg-primary/5' : '' }}">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">
                                @if($category->slug === 'hoteis')
                                    🏨
                                @elseif($category->slug === 'rent-a-car')
                                    🚗
                                @else
                                    🔗
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold leading-none tracking-tight">{{ $integration->name }}</h3>
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $integration->is_active ? 'border-transparent bg-primary text-primary-foreground hover:bg-primary/80' : 'border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80' }} mt-1">
                                    {{ $integration->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </div>
                        </div>
                        <label class="peer inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 {{ $integration->is_active ? 'data-[state=checked]:bg-primary' : 'data-[state=unchecked]:bg-input' }}">
                            <input type="checkbox" {{ $integration->is_active ? 'checked' : '' }} class="sr-only">
                            <span class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform {{ $integration->is_active ? 'data-[state=checked]:translate-x-5' : 'data-[state=unchecked]:translate-x-0' }}"></span>
                        </label>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <p class="text-sm text-muted-foreground">{{ $integration->description }}</p>
                    <div class="mt-2">
                        <a href="{{ $integration->base_url }}" target="_blank" class="text-xs text-primary hover:underline">
                            {{ $integration->base_url }}
                        </a>
                    </div>
                    <button class="w-full mt-4 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        {{ $integration->is_active ? 'Configurar' : 'Ativar' }}
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-muted-foreground">
            <p>Nenhuma integração disponível nesta categoria.</p>
        </div>
        @endif
    </div>
    @endforeach
</div>
@endsection
