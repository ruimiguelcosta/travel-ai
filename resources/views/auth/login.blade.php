@extends('layouts.app')

@section('title', 'Login - Admin Panel')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-secondary/10 to-background"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiM5MzMzZWEiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDE2djRoNHYtNGgtNHptMCA4djRoNHYtNGgtNHptLTQtNHY0aDR2LTRoLTR6bTAtNHY0aDR2LTRoLTR6bTAgOHY0aDR2LTRoLTR6bS00LTR2NGg0di00aC00em0wIDh2NGg0di00aC00eiIvPjwvZz48L2c+PC9zdmc+')] opacity-30"></div>
    
    <div class="w-full max-w-md relative shadow-2xl border border-border/50 rounded-lg bg-card text-card-foreground">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="text-3xl font-bold text-center gradient-text">
                Admin Panel
            </h3>
            <p class="text-center text-sm text-muted-foreground">
                Entre com suas credenciais para acessar o painel
            </p>
        </div>
        <div class="p-6 pt-0">
            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="seu@email.com"
                        required
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm transition-all focus:ring-2 focus:ring-primary/20"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Senha</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="••••••••"
                        required
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm transition-all focus:ring-2 focus:ring-primary/20"
                    >
                    @error('password')
                        <p class="text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>
                <button 
                    type="submit" 
                    class="w-full inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 bg-gradient-to-r from-primary to-secondary hover:opacity-90 transition-opacity text-primary-foreground"
                >
                    Entrar
                </button>
            </form>
            
            <div class="mt-6 p-4 bg-muted rounded-lg">
                <p class="text-sm text-muted-foreground text-center">
                    💡 <strong>Demo:</strong> Use qualquer email/senha para acessar
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
