@extends('layouts.app')

@section('title', 'Detalhes do Patrimônio')
@section('header', 'Detalhes do Patrimônio')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Card Principal -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-univc-600 to-univc-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-box text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $patrimonio->nome }}</h2>
                        <p class="text-univc-200 font-mono">{{ $patrimonio->codigo_barra }}</p>
                    </div>
                </div>
                <div>
                    @php
                        $situacaoColors = [
                            'disponivel' => 'bg-green-500',
                            'manutencao' => 'bg-yellow-500',
                            'emprestado' => 'bg-blue-500',
                            'descartado' => 'bg-red-500',
                            'separado_descarte' => 'bg-orange-500',
                        ];
                    @endphp
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full text-white {{ $situacaoColors[$patrimonio->situacao] ?? 'bg-gray-500' }}">
                        {{ $patrimonio->situacao_label }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Tipo de Patrimônio</h3>
                    <p class="text-gray-800">{{ $patrimonio->tipoPatrimonio?->nome ?? '-' }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Local de Armazenamento</h3>
                    <p class="text-gray-800">{{ $patrimonio->localArmazenamento?->nome ?? '-' }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Data de Cadastro</h3>
                    <p class="text-gray-800">{{ $patrimonio->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Última Atualização</h3>
                    <p class="text-gray-800">{{ $patrimonio->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            <div class="flex items-center justify-end space-x-4 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.patrimonios.index') }}" 
                   class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar
                </a>
                <a href="{{ route('admin.qrcodes.unico', $patrimonio->codigo_barra) }}" 
                   target="_blank"
                   class="px-4 py-2 text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors">
                    <i class="fas fa-qrcode mr-2"></i> Ver QR Code
                </a>
                <a href="{{ route('admin.patrimonios.edit', $patrimonio) }}" 
                   class="px-4 py-2 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </div>
    
    <!-- Histórico de Atividades -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-history text-univc-600 mr-2"></i>
            Histórico de Atividades
        </h3>
        
        <div class="space-y-4">
            @forelse($patrimonio->logs as $log)
                <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-univc-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-univc-600"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <p class="font-medium text-gray-800">{{ $log->acao }}</p>
                            <span class="text-sm text-gray-500">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="text-sm text-gray-500">Por: {{ $log->user->name }}</p>
                        @if($log->detalhes)
                            <p class="text-sm text-gray-600 mt-1">{{ $log->detalhes }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Nenhuma atividade registrada</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
