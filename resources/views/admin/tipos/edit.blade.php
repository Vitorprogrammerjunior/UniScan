@extends('layouts.app')

@section('title', 'Editar Tipo de Patrimônio')
@section('header', 'Editar Tipo de Patrimônio')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.tipos.update', $tipo) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">
                    Nome *
                </label>
                <input type="text" id="nome" name="nome" value="{{ old('nome', $tipo->nome) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                @error('nome')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="descricao" class="block text-sm font-medium text-gray-700 mb-1">
                    Descrição
                </label>
                <textarea id="descricao" name="descricao" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">{{ old('descricao', $tipo->descricao) }}</textarea>
                @error('descricao')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.tipos.index') }}" 
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
