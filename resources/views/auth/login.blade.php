<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UniScan UNIVC</title>
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
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="font-sans min-h-screen bg-gradient-to-br from-univc-600 via-univc-700 to-univc-900 flex items-center justify-center p-4">
    
    <!-- Background decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 w-64 h-64 bg-univc-400/10 rounded-full blur-3xl float"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-univc-300/10 rounded-full blur-3xl float" style="animation-delay: -3s;"></div>
    </div>
    
    <div class="w-full max-w-md fade-in relative z-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-2xl shadow-2xl mb-4 p-3">
                <img src="/images/logo-vertical.png" alt="UNIVC" class="w-full h-full object-contain">
            </div>
            <h1 class="text-3xl font-bold text-white">UniScan</h1>
            <p class="text-univc-200 mt-2">Sistema de Gestão de Patrimônios</p>
        </div>
        
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Acesso Administrativo</h2>
            
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        @foreach($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                @if(request()->has('redirect_to'))
                    <input type="hidden" name="redirect_to" value="{{ request()->redirect_to }}">
                @endif
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-1 text-univc-600"></i> E-mail
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500 transition-all duration-200"
                        placeholder="seu@email.com"
                    >
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1 text-univc-600"></i> Senha
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500 transition-all duration-200"
                        placeholder="••••••••"
                    >
                </div>
                
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember"
                        class="w-4 h-4 text-univc-600 border-gray-300 rounded focus:ring-univc-500"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-600">Lembrar de mim</label>
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-univc-600 to-univc-700 text-white py-3 px-4 rounded-lg font-semibold hover:from-univc-700 hover:to-univc-800 focus:ring-4 focus:ring-univc-300 transition-all duration-200 transform hover:scale-[1.02]"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i> Entrar
                </button>
            </form>
        </div>
        
        <!-- Footer -->
        <p class="text-center text-univc-200 text-sm mt-6">
            © {{ date('Y') }} UniScan - UNIVC | Todos os direitos reservados
        </p>
    </div>
</body>
</html>
