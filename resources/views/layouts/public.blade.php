<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Patrimônio') - UniScan UNIVC</title>
    <link rel="icon" type="image/png" href="/images/logo-vertical.png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'univc': {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .pulse-slow {
            animation: pulse 3s infinite;
        }
    </style>
</head>
<body class="font-sans bg-gradient-to-br from-univc-50 via-white to-univc-100 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-gradient-to-r from-univc-700 to-univc-600 text-white py-4 shadow-lg">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center p-1">
                            <img src="/images/logo-vertical.png" alt="UNIVC" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h1 class="font-bold text-lg">UniScan</h1>
                            <p class="text-univc-200 text-xs">Gestão de Patrimônios - UNIVC</p>
                        </div>
                    </div>
                    
                    @auth
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.dashboard') }}" class="text-sm hover:text-univc-200 transition-colors">
                                <i class="fas fa-cog mr-1"></i> Painel Admin
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>
        
        <!-- Content -->
        <main class="flex-1 container mx-auto px-4 py-8">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-univc-800 text-univc-200 py-4 text-center text-sm">
            <p>© {{ date('Y') }} UniScan - UNIVC | Sistema de Gestão de Patrimônios</p>
        </footer>
    </div>
</body>
</html>
