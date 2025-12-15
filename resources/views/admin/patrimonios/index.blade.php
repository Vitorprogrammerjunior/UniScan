@extends('layouts.app')

@section('title', 'Patrimônios')
@section('header', 'Patrimônios')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-gray-500">Gerencie todos os patrimônios cadastrados no sistema</p>
        </div>
        <a href="{{ route('admin.patrimonios.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Novo Patrimônio
        </a>
    </div>
    
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.patrimonios.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" name="busca" value="{{ request('busca') }}" 
                       placeholder="Código ou nome..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                <select name="tipo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                    <option value="">Todos</option>
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ request('tipo') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Local</label>
                <select name="local" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                    <option value="">Todos</option>
                    @foreach($locais as $local)
                        <option value="{{ $local->id }}" {{ request('local') == $local->id ? 'selected' : '' }}>
                            {{ $local->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Situação</label>
                <select name="situacao" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                    <option value="">Todas</option>
                    <option value="disponivel" {{ request('situacao') == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                    <option value="manutencao" {{ request('situacao') == 'manutencao' ? 'selected' : '' }}>Manutenção</option>
                    <option value="emprestado" {{ request('situacao') == 'emprestado' ? 'selected' : '' }}>Emprestado</option>
                    <option value="descartado" {{ request('situacao') == 'descartado' ? 'selected' : '' }}>Descartado</option>
                    <option value="separado_descarte" {{ request('situacao') == 'separado_descarte' ? 'selected' : '' }}>Separado p/ Descarte</option>
                </select>
            </div>
            
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors">
                    <i class="fas fa-search mr-1"></i> Filtrar
                </button>
                <a href="{{ route('admin.patrimonios.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
    
    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Patrimônio</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Local</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Situação</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($patrimonios as $patrimonio)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-sm font-medium text-univc-600">{{ $patrimonio->codigo_barra }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $patrimonio->nome }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ $patrimonio->tipoPatrimonio?->nome ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ $patrimonio->localArmazenamento?->nome ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $situacaoColors = [
                                        'disponivel' => 'bg-green-100 text-green-800',
                                        'manutencao' => 'bg-yellow-100 text-yellow-800',
                                        'emprestado' => 'bg-blue-100 text-blue-800',
                                        'descartado' => 'bg-red-100 text-red-800',
                                        'separado_descarte' => 'bg-orange-100 text-orange-800',
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $situacaoColors[$patrimonio->situacao] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $patrimonio->situacao_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.patrimonios.show', $patrimonio) }}" 
                                       class="p-2 text-gray-500 hover:text-univc-600 hover:bg-univc-50 rounded-lg transition-colors"
                                       title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.patrimonios.edit', $patrimonio) }}" 
                                       class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.qrcodes.unico', $patrimonio->codigo_barra) }}" 
                                       target="_blank"
                                       class="p-2 text-gray-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                                       title="QR Code">
                                        <i class="fas fa-qrcode"></i>
                                    </a>
                                    <form action="{{ route('admin.patrimonios.destroy', $patrimonio) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este patrimônio?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 mb-2">Nenhum patrimônio encontrado</p>
                                    <a href="{{ route('admin.patrimonios.create') }}" class="text-univc-600 hover:text-univc-800">
                                        Cadastrar novo patrimônio <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($patrimonios->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $patrimonios->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
