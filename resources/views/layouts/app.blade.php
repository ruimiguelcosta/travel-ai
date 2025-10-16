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
    @yield('content')
    @stack('scripts')
</body>
</html>
