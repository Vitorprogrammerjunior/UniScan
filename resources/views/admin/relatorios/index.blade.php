@extends('layouts.app')

@section('title', 'Relatórios')
@section('header', 'Relatórios')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                Gerar Relatório de Patrimônios
            </h3>
            <p class="text-gray-500 text-sm">
                Exporte um relatório em PDF com os patrimônios cadastrados. Use os filtros para personalizar o relatório.
            </p>
        </div>
        
        <form action="{{ route('admin.relatorios.gerar') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">
                    Tipo de Patrimônio
                </label>
                <select id="tipo" name="tipo"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                    <option value="">Todos os tipos</option>
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="local" class="block text-sm font-medium text-gray-700 mb-1">
                    Local de Armazenamento
                </label>
                <select id="local" name="local"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                    <option value="">Todos os locais</option>
                    @foreach($locais as $local)
                        <option value="{{ $local->id }}">{{ $local->nome }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="situacao" class="block text-sm font-medium text-gray-700 mb-1">
                    Situação
                </label>
                <select id="situacao" name="situacao"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                    <option value="">Todas as situações</option>
                    <option value="disponivel">Disponível</option>
                    <option value="manutencao">Manutenção</option>
                    <option value="emprestado">Emprestado</option>
                    <option value="descartado">Descartado</option>
                    <option value="separado_descarte">Separado p/ Descarte</option>
                </select>
            </div>
            
            <button type="submit" 
                    class="w-full px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                <i class="fas fa-download mr-2"></i> Gerar e Baixar PDF
            </button>
        </form>
    </div>
</div>
@endsection
