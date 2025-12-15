@extends('layouts.public')

@section('title', 'Patrimônio ' . $patrimonio->codigo_barra)

@section('content')
<div class="max-w-lg mx-auto fade-in">
    @if(session('success'))
        <div class="mb-6 bg-univc-100 border-l-4 border-univc-500 text-univc-700 p-4 rounded-r-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-8 text-center">
            <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-qrcode text-white text-3xl"></i>
            </div>
            <p class="text-orange-100 text-sm uppercase tracking-wide mb-1">Código do Patrimônio</p>
            <h1 class="text-3xl font-bold text-white font-mono">{{ $patrimonio->codigo_barra }}</h1>
        </div>
        
        <!-- Status -->
        <div class="p-6">
            <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 text-center mb-6">
                <i class="fas fa-exclamation-circle text-orange-500 text-2xl mb-2"></i>
                <p class="text-orange-800 font-medium">Este patrimônio ainda não foi cadastrado</p>
                <p class="text-orange-600 text-sm mt-1">Apenas administradores podem cadastrar novos patrimônios</p>
            </div>
            
            @if($isAdmin)
                <!-- Formulário de Cadastro (para Admin logado) -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-edit text-univc-600 mr-2"></i>
                        Cadastrar Patrimônio
                    </h3>
                    
                    <form action="{{ route('admin.patrimonios.cadastrar-pendente', $patrimonio) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">
                                Nome/Descrição *
                            </label>
                            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500"
                                   placeholder="Ex: ADAPTADOR P/CAMERA DEVIDEO">
                            @error('nome')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="tipo_patrimonio_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Tipo *
                            </label>
                            <select id="tipo_patrimonio_id" name="tipo_patrimonio_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                                <option value="">Selecione...</option>
                                @foreach(\App\Models\TipoPatrimonio::orderBy('nome')->get() as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                                @endforeach
                            </select>
                            @error('tipo_patrimonio_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="local_armazenamento_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Local *
                            </label>
                            <select id="local_armazenamento_id" name="local_armazenamento_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                                <option value="">Selecione...</option>
                                @foreach(\App\Models\LocalArmazenamento::orderBy('nome')->get() as $local)
                                    <option value="{{ $local->id }}">{{ $local->nome }}</option>
                                @endforeach
                            </select>
                            @error('local_armazenamento_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="situacao" class="block text-sm font-medium text-gray-700 mb-1">
                                Situação *
                            </label>
                            <select id="situacao" name="situacao" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                                <option value="disponivel" selected>Disponível</option>
                                <option value="manutencao">Manutenção</option>
                                <option value="emprestado">Emprestado</option>
                                <option value="descartado">Descartado</option>
                                <option value="separado_descarte">Separado p/ Descarte</option>
                            </select>
                        </div>
                        
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors font-medium">
                            <i class="fas fa-save mr-2"></i> Cadastrar Patrimônio
                        </button>
                    </form>
                </div>
            @else
                <!-- Botão de Login (para visitantes) -->
                <a href="{{ route('login', ['redirect_to' => url()->current()]) }}" 
                   class="block w-full text-center px-6 py-3 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors font-medium">
                    <i class="fas fa-sign-in-alt mr-2"></i> Entrar como Administrador
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
