<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UniScan') - UNIVC</title>
    <link rel="icon" type="image/png" href="/images/logo-vertical.png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js para interatividade -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
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
        [x-cloak] { display: none !important; }
        
        /* Animações suaves */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .slide-in {
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        
        /* Hover effects */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #22c55e;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #16a34a;
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans bg-gray-50 min-h-screen">
    <div x-data="{ sidebarOpen: true }" class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside 
            :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="bg-gradient-to-b from-univc-700 to-univc-900 text-white transition-all duration-300 ease-in-out flex flex-col shadow-xl"
        >
            <!-- Logo -->
            <div class="p-4 border-b border-univc-600">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center p-1">
                        <img src="/images/logo-vertical.png" alt="UNIVC" class="w-full h-full object-contain">
                    </div>
                    <div x-show="sidebarOpen" x-cloak>
                        <span class="font-bold text-lg">UniScan</span>
                        <p class="text-xs text-univc-300">Gestão de Patrimônios</p>
                    </div>
                </div>
            </div>
            
            <!-- Menu -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                          {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-chart-pie w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-cloak>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.patrimonios.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                          {{ request()->routeIs('admin.patrimonios.*') ? 'bg-white/20 text-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-boxes-stacked w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-cloak>Patrimônios</span>
                </a>
                
                <a href="{{ route('admin.patrimonios.pendentes') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                          {{ request()->routeIs('admin.patrimonios.pendentes') ? 'bg-white/20 text-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-clock w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-cloak>Pendentes</span>
                </a>
                
                <a href="{{ route('admin.tipos.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                          {{ request()->routeIs('admin.tipos.*') ? 'bg-white/20 text-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-tags w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-cloak>Tipos</span>
                </a>
                
                <a href="{{ route('admin.locais.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                          {{ request()->routeIs('admin.locais.*') ? 'bg-white/20 text-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-location-dot w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-cloak>Locais</span>
                </a>
                
                <!-- Separador -->
                <div class="my-3 border-t border-univc-600" x-show="sidebarOpen"></div>
                <p class="px-4 text-xs text-univc-300 uppercase tracking-wider mb-2" x-show="sidebarOpen" x-cloak>QR Codes</p>
                
                <a href="{{ route('admin.qrcodes.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                          {{ request()->routeIs('admin.qrcodes.index') ? 'bg-white/20 text-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-qrcode w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-cloak>Gerar QR Codes</span>
                </a>
                
                <a href="{{ route('admin.qrcodes.pendentes') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                          {{ request()->routeIs('admin.qrcodes.pendentes') ? 'bg-white/20 text-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-print w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-cloak>QR Codes Pendentes</span>
                </a>
                
                <!-- Separador -->
                <div class="my-3 border-t border-univc-600" x-show="sidebarOpen"></div>
                
                <a href="{{ route('admin.relatorios.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                          {{ request()->routeIs('admin.relatorios.*') ? 'bg-white/20 text-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-file-pdf w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-cloak>Relatórios</span>
                </a>
            </nav>
            
            <!-- Logout -->
            <div class="p-4 border-t border-univc-600">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-500/20 transition-all duration-200 text-red-200">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span x-show="sidebarOpen" x-cloak>Sair</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="text-gray-500 hover:text-univc-600 transition-colors">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-user-circle mr-1"></i>
                            {{ Auth::user()->name }}
                        </span>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Alertas -->
                @if(session('success'))
                    <div class="mb-6 bg-univc-100 border-l-4 border-univc-500 text-univc-700 p-4 rounded-r-lg fade-in" 
                         x-data="{ show: true }" 
                         x-show="show"
                         x-init="setTimeout(() => show = false, 5000)">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                            </div>
                            <button @click="show = false" class="text-univc-500 hover:text-univc-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg fade-in">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
