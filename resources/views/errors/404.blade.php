@extends('layouts.app')

@section('title', 'Página não encontrada - Admin Panel')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="text-center">
        <h1 class="text-6xl font-bold gradient-text mb-4">404</h1>
        <h2 class="text-2xl font-semibold mb-2">Página não encontrada</h2>
        <p class="text-muted-foreground mb-8">A página que você está procurando não existe.</p>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 bg-gradient-to-r from-primary to-secondary text-primary-foreground hover:opacity-90">
            Voltar ao Dashboard
        </a>
    </div>
</div>
@endsection
