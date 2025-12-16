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
                
                <a href="{{ route('admin.emprestimos.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 
                          {{ request()->routeIs('admin.emprestimos.*') ? 'bg-white/20 text-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-exchange-alt w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-cloak>Emprestados</span>
                </a>
                
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
    
    <!-- Pop-up de Atualização -->
    @php
        $versaoAtual = config('versao.atual');
        $changelog = config('versao.changelog.' . $versaoAtual);
        $mostrarPopup = auth()->check() && auth()->user()->versao_vista !== $versaoAtual;
    @endphp
    
    @if($mostrarPopup)
    <div x-data="{ 
            showModal: true,
            loading: false,
            async fechar() {
                this.loading = true;
                await fetch('{{ route('admin.versao.vista') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                this.showModal = false;
            }
         }"
         x-show="showModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        
        <!-- Backdrop com blur -->
        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        
        <!-- Modal -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="showModal"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 scale-75 translate-y-8"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-75"
                 class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden">
                
                <!-- Confetes animados -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <div class="confetti"></div>
                </div>
                
                <!-- Header com animação -->
                <div class="relative bg-gradient-to-br from-univc-500 via-univc-600 to-univc-700 px-6 py-10 text-center overflow-hidden">
                    <!-- Círculos decorativos animados -->
                    <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2 animate-pulse"></div>
                    <div class="absolute bottom-0 right-0 w-24 h-24 bg-white/10 rounded-full translate-x-1/2 translate-y-1/2 animate-pulse" style="animation-delay: 0.5s"></div>
                    
                    <div class="relative">
                        <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg animate-bounce" style="animation-duration: 2s">
                            <i class="fas fa-sparkles text-univc-600 text-3xl"></i>
                        </div>
                        <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-white text-xs font-medium mb-3">
                            ✨ NOVA VERSÃO
                        </span>
                        <h2 class="text-2xl font-bold text-white">{{ $changelog['titulo'] ?? 'Atualização!' }}</h2>
                        <p class="text-univc-200 text-sm mt-2">
                            <i class="fas fa-code-branch mr-1"></i> Versão {{ $versaoAtual }} • {{ $changelog['data'] ?? '' }}
                        </p>
                    </div>
                </div>
                
                <!-- Conteúdo -->
                <div class="px-6 py-6">
                    <p class="text-gray-500 text-sm mb-5 text-center">Olá <strong class="text-univc-600">{{ auth()->user()->name }}</strong>! Confira as novidades:</p>
                    
                    <div class="space-y-3">
                        @foreach($changelog['mudancas'] ?? [] as $index => $mudanca)
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors"
                                 style="animation: slideIn 0.5s ease-out {{ ($index + 1) * 0.1 }}s both">
                                @php
                                    $cores = [
                                        'blue' => 'bg-blue-100 text-blue-600',
                                        'green' => 'bg-green-100 text-green-600',
                                        'purple' => 'bg-purple-100 text-purple-600',
                                        'red' => 'bg-red-100 text-red-600',
                                        'yellow' => 'bg-yellow-100 text-yellow-600',
                                    ];
                                    $corClasse = $cores[$mudanca['cor'] ?? 'green'] ?? $cores['green'];
                                @endphp
                                <span class="flex-shrink-0 w-10 h-10 {{ $corClasse }} rounded-xl flex items-center justify-center">
                                    <i class="fas {{ $mudanca['icone'] ?? 'fa-check' }}"></i>
                                </span>
                                <span class="text-gray-700 text-sm pt-2">{{ $mudanca['texto'] ?? $mudanca }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="px-6 pb-6">
                    <button @click="fechar()" 
                            :disabled="loading"
                            class="w-full px-6 py-4 bg-gradient-to-r from-univc-600 to-univc-700 text-white rounded-xl hover:from-univc-700 hover:to-univc-800 transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50">
                        <span x-show="!loading">
                            <i class="fas fa-rocket mr-2"></i> Vamos lá!
                        </span>
                        <span x-show="loading">
                            <i class="fas fa-spinner fa-spin mr-2"></i> Salvando...
                        </span>
                    </button>
                    <p class="text-center text-gray-400 text-xs mt-3">
                        Obrigado por usar o UniScan! 💚
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
    @endif
    
    @stack('scripts')
</body>
</html>
