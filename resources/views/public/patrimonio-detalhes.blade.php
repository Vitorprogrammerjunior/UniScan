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
        <div class="bg-gradient-to-r from-univc-600 to-univc-700 px-6 py-8 text-center relative">
            <!-- Ícone de Admin/Login -->
            @if($isAdmin)
                <a href="#editar" 
                   onclick="document.getElementById('editForm').classList.toggle('hidden'); return false;"
                   class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center transition-colors"
                   title="Editar patrimônio">
                    <i class="fas fa-edit text-white"></i>
                </a>
            @else
                <a href="{{ route('login', ['redirect_to' => url()->current()]) }}" 
                   class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center transition-colors"
                   title="Login de administrador">
                    <i class="fas fa-user-shield text-white"></i>
                </a>
            @endif
            
            <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-box text-white text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white mb-1">{{ $patrimonio->nome }}</h1>
            <p class="text-univc-200 font-mono text-lg">{{ $patrimonio->codigo_barra }}</p>
        </div>
        
        <!-- Informações -->
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-univc-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tags text-univc-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Tipo</p>
                        <p class="font-medium text-gray-800">{{ $patrimonio->tipoPatrimonio?->nome ?? 'Não informado' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-univc-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-location-dot text-univc-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Local</p>
                        <p class="font-medium text-gray-800">{{ $patrimonio->localArmazenamento?->nome ?? 'Não informado' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    @php
                        $situacaoConfig = [
                            'disponivel' => ['icon' => 'fa-check-circle', 'bg' => 'bg-green-100', 'text' => 'text-green-600', 'badge' => 'bg-green-500'],
                            'manutencao' => ['icon' => 'fa-wrench', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-600', 'badge' => 'bg-yellow-500'],
                            'emprestado' => ['icon' => 'fa-hand-holding', 'bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'badge' => 'bg-blue-500'],
                            'descartado' => ['icon' => 'fa-trash', 'bg' => 'bg-red-100', 'text' => 'text-red-600', 'badge' => 'bg-red-500'],
                            'separado_descarte' => ['icon' => 'fa-exclamation-triangle', 'bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'badge' => 'bg-orange-500'],
                        ];
                        $config = $situacaoConfig[$patrimonio->situacao] ?? $situacaoConfig['disponivel'];
                    @endphp
                    <div class="w-10 h-10 {{ $config['bg'] }} rounded-lg flex items-center justify-center">
                        <i class="fas {{ $config['icon'] }} {{ $config['text'] }}"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Situação</p>
                        <p class="font-medium text-gray-800">{{ $patrimonio->situacao_label }}</p>
                    </div>
                </div>
                <span class="w-3 h-3 {{ $config['badge'] }} rounded-full animate-pulse"></span>
            </div>
        </div>
        
        <!-- Formulário de Edição (apenas para Admin) -->
        @if($isAdmin)
            <div id="editForm" class="hidden px-6 pb-6 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-edit text-univc-600 mr-2"></i>
                    Editar Patrimônio
                </h3>
                
                <form action="{{ route('admin.patrimonios.update', $patrimonio) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                    
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">
                            Nome/Descrição *
                        </label>
                        <input type="text" id="nome" name="nome" value="{{ $patrimonio->nome }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                    </div>
                    
                    <div>
                        <label for="tipo_patrimonio_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Tipo *
                        </label>
                        <select id="tipo_patrimonio_id" name="tipo_patrimonio_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                            @foreach(\App\Models\TipoPatrimonio::orderBy('nome')->get() as $tipo)
                                <option value="{{ $tipo->id }}" {{ $patrimonio->tipo_patrimonio_id == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="local_armazenamento_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Local *
                        </label>
                        <select id="local_armazenamento_id" name="local_armazenamento_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                            @foreach(\App\Models\LocalArmazenamento::orderBy('nome')->get() as $local)
                                <option value="{{ $local->id }}" {{ $patrimonio->local_armazenamento_id == $local->id ? 'selected' : '' }}>
                                    {{ $local->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="situacao" class="block text-sm font-medium text-gray-700 mb-1">
                            Situação *
                        </label>
                        <select id="situacao" name="situacao" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                            <option value="disponivel" {{ $patrimonio->situacao == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                            <option value="manutencao" {{ $patrimonio->situacao == 'manutencao' ? 'selected' : '' }}>Manutenção</option>
                            <option value="emprestado" {{ $patrimonio->situacao == 'emprestado' ? 'selected' : '' }}>Emprestado</option>
                            <option value="descartado" {{ $patrimonio->situacao == 'descartado' ? 'selected' : '' }}>Descartado</option>
                            <option value="separado_descarte" {{ $patrimonio->situacao == 'separado_descarte' ? 'selected' : '' }}>Separado p/ Descarte</option>
                        </select>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="button" 
                                onclick="document.getElementById('editForm').classList.add('hidden')"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="flex-1 px-4 py-2 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors">
                            <i class="fas fa-save mr-2"></i> Salvar
                        </button>
                    </div>
                </form>
            </div>
        @endif
        
        <!-- Footer -->
        <div class="px-6 pb-6">
            <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                <img src="/images/logo-vertical.png" alt="UNIVC" class="w-6 h-6 object-contain">
                <p>Patrimônio gerenciado por <strong class="text-univc-600">UniScan</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
