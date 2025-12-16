@extends('layouts.app')

@section('title', 'Emprestados')
@section('header', 'Patrimônios Emprestados')

@section('content')
<div class="space-y-6">
    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <form action="{{ route('admin.emprestimos.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
            <div class="flex-1">
                <label for="busca" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" id="busca" name="busca" value="{{ request('busca') }}"
                       placeholder="Código ou nome do patrimônio..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
            </div>
            
            <div class="w-full md:w-48">
                <label for="local_original" class="block text-sm font-medium text-gray-700 mb-1">Local de Origem</label>
                <select id="local_original" name="local_original"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                    <option value="">Todos</option>
                    @foreach($locais as $local)
                        <option value="{{ $local->id }}" {{ request('local_original') == $local->id ? 'selected' : '' }}>
                            {{ $local->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full md:w-48">
                <label for="local_destino" class="block text-sm font-medium text-gray-700 mb-1">Local de Destino</label>
                <select id="local_destino" name="local_destino"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500">
                    <option value="">Todos</option>
                    @foreach($locais as $local)
                        <option value="{{ $local->id }}" {{ request('local_destino') == $local->id ? 'selected' : '' }}>
                            {{ $local->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors">
                    <i class="fas fa-search mr-1"></i> Filtrar
                </button>
                <a href="{{ route('admin.emprestimos.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm">Total Emprestados</p>
                    <p class="text-3xl font-bold">{{ $emprestimos->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exchange-alt text-xl"></i>
                </div>
            </div>
        </div>

        @php
            $emprestadosHoje = \App\Models\Emprestimo::ativos()->whereDate('data_emprestimo', today())->count();
            $emprestadosSemana = \App\Models\Emprestimo::ativos()->whereBetween('data_emprestimo', [now()->startOfWeek(), now()->endOfWeek()])->count();
        @endphp

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Emprestados Hoje</p>
                    <p class="text-3xl font-bold">{{ $emprestadosHoje }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-day text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Esta Semana</p>
                    <p class="text-3xl font-bold">{{ $emprestadosSemana }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-week text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Empréstimos -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        @if($emprestimos->isEmpty())
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exchange-alt text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhum empréstimo ativo</h3>
                <p class="text-gray-500">Não há patrimônios emprestados no momento.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patrimônio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Empréstimo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Por</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($emprestimos as $emprestimo)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-box text-yellow-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $emprestimo->patrimonio->codigo_barra }}</p>
                                            <p class="text-sm text-gray-500 truncate max-w-xs">{{ $emprestimo->patrimonio->nome }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium">
                                            {{ $emprestimo->localOriginal->nome }}
                                        </span>
                                        <i class="fas fa-arrow-right text-gray-400"></i>
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                                            {{ $emprestimo->localEmprestado->nome }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div>
                                        <p class="text-gray-900">{{ $emprestimo->data_emprestimo->format('d/m/Y') }}</p>
                                        <p class="text-sm text-gray-500">{{ $emprestimo->data_emprestimo->format('H:i') }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-gray-600">{{ $emprestimo->user?->name ?? 'Sistema' }}</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <a href="{{ route('admin.patrimonios.edit', $emprestimo->patrimonio_id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-univc-100 text-univc-700 rounded-lg hover:bg-univc-200 transition-colors text-sm">
                                        <i class="fas fa-edit mr-1"></i> Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $emprestimos->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
