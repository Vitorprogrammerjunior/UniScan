@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-6 hover-lift border-l-4 border-univc-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Cadastrados</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-univc-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-boxes-stacked text-univc-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 hover-lift border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Disponíveis</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['disponiveis'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 hover-lift border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Manutenção</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['manutencao'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-wrench text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 hover-lift border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Emprestados</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['emprestados'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-hand-holding text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 hover-lift border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Descartados</p>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['descartados'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-trash text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 hover-lift border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pendentes</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['pendentes'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Por Tipo -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-tags text-univc-600 mr-2"></i>
                Por Tipo de Patrimônio
            </h3>
            <div class="space-y-3">
                @forelse($porTipo as $tipo)
                    @php
                        $percent = $stats['total'] > 0 ? ($tipo->patrimonios_count / $stats['total']) * 100 : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">{{ $tipo->nome }}</span>
                            <span class="font-medium">{{ $tipo->patrimonios_count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-univc-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Nenhum tipo cadastrado</p>
                @endforelse
            </div>
        </div>
        
        <!-- Por Local -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-location-dot text-univc-600 mr-2"></i>
                Por Local de Armazenamento
            </h3>
            <div class="space-y-3">
                @forelse($porLocal as $local)
                    @php
                        $percent = $stats['total'] > 0 ? ($local->patrimonios_count / $stats['total']) * 100 : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">{{ $local->nome }}</span>
                            <span class="font-medium">{{ $local->patrimonios_count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-univc-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Nenhum local cadastrado</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Últimos Patrimônios -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-clock text-univc-600 mr-2"></i>
                    Últimos Cadastros
                </h3>
                <a href="{{ route('admin.patrimonios.index') }}" class="text-sm text-univc-600 hover:text-univc-800">
                    Ver todos <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-3">
                @forelse($ultimosPatrimonios as $patrimonio)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-univc-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-univc-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $patrimonio->nome }}</p>
                                <p class="text-sm text-gray-500">{{ $patrimonio->codigo_barra }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $patrimonio->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Nenhum patrimônio cadastrado</p>
                @endforelse
            </div>
        </div>
        
        <!-- Últimos Logs -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-history text-univc-600 mr-2"></i>
                Atividades Recentes
            </h3>
            <div class="space-y-3">
                @forelse($ultimosLogs as $log)
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-univc-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-univc-600 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-800">
                                <span class="font-medium">{{ $log->user->name }}</span>
                                <span class="text-gray-500">{{ $log->acao }}</span>
                            </p>
                            <p class="text-xs text-gray-500 truncate">{{ $log->patrimonio->codigo_barra }} - {{ $log->patrimonio->nome }}</p>
                            <p class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Nenhuma atividade registrada</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
