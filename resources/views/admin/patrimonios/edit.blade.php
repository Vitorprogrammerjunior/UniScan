@extends('layouts.app')

@section('title', 'Editar Patrimônio')
@section('header', 'Editar Patrimônio')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.patrimonios.update', $patrimonio) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="codigo_barra" class="block text-sm font-medium text-gray-700 mb-1">
                    Código de Barras *
                </label>
                <input type="text" id="codigo_barra" name="codigo_barra" 
                       value="{{ old('codigo_barra', $patrimonio->codigo_barra) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500"
                       placeholder="Ex: 001234">
                @error('codigo_barra')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">
                    Nome/Descrição do Patrimônio *
                </label>
                <input type="text" id="nome" name="nome" 
                       value="{{ old('nome', $patrimonio->nome) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500"
                       placeholder="Ex: ADAPTADOR P/CAMERA DEVIDEO, UTV1X">
                @error('nome')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="tipo_patrimonio_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Tipo de Patrimônio *
                    </label>
                    <select id="tipo_patrimonio_id" name="tipo_patrimonio_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                        <option value="">Selecione...</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}" 
                                {{ old('tipo_patrimonio_id', $patrimonio->tipo_patrimonio_id) == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_patrimonio_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="local_armazenamento_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Local de Armazenamento *
                    </label>
                    <select id="local_armazenamento_id" name="local_armazenamento_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                        <option value="">Selecione...</option>
                        @foreach($locais as $local)
                            <option value="{{ $local->id }}" 
                                {{ old('local_armazenamento_id', $patrimonio->local_armazenamento_id) == $local->id ? 'selected' : '' }}>
                                {{ $local->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('local_armazenamento_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="situacao" class="block text-sm font-medium text-gray-700 mb-1">
                    Situação *
                </label>
                <select id="situacao" name="situacao" required
                        x-data
                        x-on:change="$dispatch('situacao-changed', $event.target.value)"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                    <option value="disponivel" {{ old('situacao', $patrimonio->situacao) == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                    <option value="manutencao" {{ old('situacao', $patrimonio->situacao) == 'manutencao' ? 'selected' : '' }}>Manutenção</option>
                    <option value="emprestado" {{ old('situacao', $patrimonio->situacao) == 'emprestado' ? 'selected' : '' }}>Emprestado</option>
                    <option value="descartado" {{ old('situacao', $patrimonio->situacao) == 'descartado' ? 'selected' : '' }}>Descartado</option>
                    <option value="separado_descarte" {{ old('situacao', $patrimonio->situacao) == 'separado_descarte' ? 'selected' : '' }}>Separado p/ Descarte</option>
                </select>
                @error('situacao')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            @php
                $emprestimoAtivo = $patrimonio->emprestimos()->where('devolvido', false)->first();
            @endphp
            
            <!-- Campos de Empréstimo (aparecem apenas quando situação = emprestado) -->
            <div x-data="{ mostrar: '{{ old('situacao', $patrimonio->situacao) }}' === 'emprestado' }"
                 x-on:situacao-changed.window="mostrar = $event.detail === 'emprestado'"
                 x-show="mostrar"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-cloak
                 class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 space-y-4">
                
                <div class="flex items-center space-x-2 text-yellow-700 mb-2">
                    <i class="fas fa-exchange-alt"></i>
                    <span class="font-medium">Informações do Empréstimo</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="local_original_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Local de Origem *
                        </label>
                        <select id="local_original_id" name="local_original_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                            <option value="">Selecione...</option>
                            @foreach($locais as $local)
                                <option value="{{ $local->id }}" 
                                    {{ old('local_original_id', $emprestimoAtivo?->local_original_id) == $local->id ? 'selected' : '' }}>
                                    {{ $local->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('local_original_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="local_emprestado_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Local de Destino *
                        </label>
                        <select id="local_emprestado_id" name="local_emprestado_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                            <option value="">Selecione...</option>
                            @foreach($locais as $local)
                                <option value="{{ $local->id }}" 
                                    {{ old('local_emprestado_id', $emprestimoAtivo?->local_emprestado_id) == $local->id ? 'selected' : '' }}>
                                    {{ $local->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('local_emprestado_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                @if($emprestimoAtivo)
                    <p class="text-xs text-yellow-600">
                        <i class="fas fa-clock mr-1"></i>
                        Emprestado desde: {{ $emprestimoAtivo->data_emprestimo->format('d/m/Y H:i') }}
                    </p>
                @else
                    <p class="text-xs text-yellow-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        O empréstimo será registrado automaticamente ao salvar.
                    </p>
                @endif
            </div>
            
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.patrimonios.index') }}" 
                   class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors">
                    <i class="fas fa-save mr-2"></i> Atualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
