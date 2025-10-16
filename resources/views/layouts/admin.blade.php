<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: 'hsl(240 10% 98%)',
                        foreground: 'hsl(240 10% 10%)',
                        card: 'hsl(0 0% 100%)',
                        'card-foreground': 'hsl(240 10% 10%)',
                        popover: 'hsl(0 0% 100%)',
                        'popover-foreground': 'hsl(240 10% 10%)',
                        primary: 'hsl(262 83% 58%)',
                        'primary-foreground': 'hsl(0 0% 100%)',
                        secondary: 'hsl(220 70% 50%)',
                        'secondary-foreground': 'hsl(0 0% 100%)',
                        muted: 'hsl(240 5% 96%)',
                        'muted-foreground': 'hsl(240 4% 46%)',
                        accent: 'hsl(270 100% 97%)',
                        'accent-foreground': 'hsl(262 83% 58%)',
                        destructive: 'hsl(0 84.2% 60.2%)',
                        'destructive-foreground': 'hsl(0 0% 100%)',
                        border: 'hsl(240 6% 90%)',
                        input: 'hsl(240 6% 90%)',
                        ring: 'hsl(262 83% 58%)',
                        'sidebar-background': 'hsl(240 10% 3.9%)',
                        'sidebar-foreground': 'hsl(240 5% 84%)',
                        'sidebar-primary': 'hsl(262 83% 58%)',
                        'sidebar-primary-foreground': 'hsl(0 0% 100%)',
                        'sidebar-accent': 'hsl(240 4% 15.9%)',
                        'sidebar-accent-foreground': 'hsl(240 5% 84%)',
                        'sidebar-border': 'hsl(240 4% 15.9%)',
                        'sidebar-ring': 'hsl(262 83% 58%)',
                    },
                    borderRadius: {
                        lg: '0.75rem',
                        md: '0.5rem',
                        sm: '0.375rem',
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-text {
            background: linear-gradient(135deg, hsl(262 83% 58%), hsl(220 70% 50%));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .gradient-bg {
            background: linear-gradient(135deg, hsl(262 83% 58%), hsl(220 70% 50%));
        }
        .gradient-bg-light {
            background: linear-gradient(135deg, hsl(262 83% 58% / 0.1), hsl(220 70% 50% / 0.1));
        }
        .sidebar-collapsed {
            width: 3.5rem;
        }
        .sidebar-expanded {
            width: 16rem;
        }
        .sidebar-transition {
            transition: width 0.2s ease-in-out;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-foreground">
    <div class="flex min-h-screen w-full">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar-expanded sidebar-transition bg-sidebar-background text-sidebar-foreground flex flex-col">
            <div class="flex flex-col gap-2 p-2">
                <div class="px-4 py-6">
                    <h2 class="text-xl font-bold gradient-text">
                        Admin Panel
                    </h2>
                </div>
                
                <div class="relative flex w-full min-w-0 flex-col p-2">
                    <div class="flex h-8 shrink-0 items-center rounded-md px-2 text-xs font-medium text-sidebar-foreground/70">
                        Menu Principal
                    </div>
                    <div class="w-full text-sm">
                        <ul class="flex w-full min-w-0 flex-col gap-1">
                            <li class="group/menu-item relative">
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-none transition-[width,height,padding] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground {{ request()->routeIs('admin.dashboard') ? 'bg-sidebar-accent text-sidebar-accent-foreground font-medium' : '' }}">
                                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="group/menu-item relative">
                                <a href="{{ route('admin.copilot') }}" 
                                   class="flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-none transition-[width,height,padding] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground {{ request()->routeIs('admin.copilot') ? 'bg-sidebar-accent text-sidebar-accent-foreground font-medium' : '' }}">
                                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <span>AI Copilot</span>
                                </a>
                            </li>
                            <li class="group/menu-item relative">
                                <a href="{{ route('admin.integracoes') }}" 
                                   class="flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-none transition-[width,height,padding] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground {{ request()->routeIs('admin.integracoes') ? 'bg-sidebar-accent text-sidebar-accent-foreground font-medium' : '' }}">
                                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    <span>Integrações</span>
                                </a>
                            </li>
                            <li class="group/menu-item relative">
                                <a href="{{ route('admin.orcamento') }}" 
                                   class="flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-none transition-[width,height,padding] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground {{ request()->routeIs('admin.orcamento') ? 'bg-sidebar-accent text-sidebar-accent-foreground font-medium' : '' }}">
                                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Orçamento</span>
                                </a>
                            </li>
                            <li class="group/menu-item relative">
                                <a href="{{ route('admin.pos-venda') }}" 
                                   class="flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-none transition-[width,height,padding] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground {{ request()->routeIs('admin.pos-venda') ? 'bg-sidebar-accent text-sidebar-accent-foreground font-medium' : '' }}">
                                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span>Pós-venda</span>
                                </a>
                            </li>
                            <li class="group/menu-item relative">
                                <a href="{{ route('admin.clientes') }}" 
                                   class="flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-none transition-[width,height,padding] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground {{ request()->routeIs('admin.clientes') ? 'bg-sidebar-accent text-sidebar-accent-foreground font-medium' : '' }}">
                                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    <span>Clientes</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-2 p-2 mt-auto">
                <div class="mb-2 text-sm text-sidebar-foreground/60">
                    admin@example.com
                </div>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-none transition-[width,height,padding] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Sair</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <header class="h-16 border-b flex items-center px-6 bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 sticky top-0 z-10">
                <button id="sidebar-toggle" class="h-7 w-7 inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </header>
            <div class="flex-1 p-6 overflow-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
            
            if (isCollapsed) {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
            } else {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
