@extends('layouts.app')

@section('title', 'Patrimônios Pendentes')
@section('header', 'Patrimônios Pendentes')

@section('content')
<div class="space-y-6" x-data="{ selecionados: [] }">
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
        <div class="flex items-center">
            <i class="fas fa-info-circle text-yellow-500 mr-2"></i>
            <p class="text-yellow-700">
                Patrimônios com QR Code gerado mas ainda não cadastrados. Clique em "Cadastrar" ou escaneie o QR Code para preencher as informações.
            </p>
        </div>
    </div>
    
    <!-- Ações em lote -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-500" x-show="selecionados.length > 0" x-cloak>
                <span x-text="selecionados.length"></span> selecionado(s)
            </span>
        </div>
        <form action="{{ route('admin.qrcodes.imprimir') }}" method="POST" x-show="selecionados.length > 0" x-cloak>
            @csrf
            <template x-for="codigo in selecionados" :key="codigo">
                <input type="hidden" name="codigos[]" :value="codigo">
            </template>
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-print mr-2"></i> Imprimir Selecionados
            </button>
        </form>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" 
                                   class="rounded border-gray-300 text-univc-600 focus:ring-univc-500"
                                   @change="selecionados = $event.target.checked ? [...document.querySelectorAll('.patrimonio-check')].map(el => el.value) : []">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Criado em</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">QR Code</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($patrimonios as $patrimonio)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" 
                                       class="patrimonio-check rounded border-gray-300 text-univc-600 focus:ring-univc-500"
                                       value="{{ $patrimonio->codigo_barra }}"
                                       x-model="selecionados">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-sm font-medium text-orange-600">{{ $patrimonio->codigo_barra }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ $patrimonio->created_at->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('admin.qrcodes.unico', $patrimonio->codigo_barra) }}" 
                                   target="_blank"
                                   class="inline-block w-12 h-12 p-1 border border-gray-200 rounded-lg hover:border-univc-500 transition-colors">
                                    <img src="{{ route('admin.qrcodes.unico', $patrimonio->codigo_barra) }}" 
                                         alt="QR {{ $patrimonio->codigo_barra }}"
                                         class="w-full h-full">
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('patrimonio.verificar', $patrimonio->codigo_barra) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-univc-600 text-white text-sm rounded-lg hover:bg-univc-700 transition-colors">
                                        <i class="fas fa-plus mr-1"></i> Cadastrar
                                    </a>
                                    <form action="{{ route('admin.qrcodes.imprimir') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="codigos[]" value="{{ $patrimonio->codigo_barra }}">
                                        <button type="submit" 
                                                class="p-2 text-gray-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                                                title="Imprimir QR Code">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-check text-green-500 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 mb-2">Nenhum patrimônio pendente de cadastro!</p>
                                    <a href="{{ route('admin.qrcodes.index') }}" class="text-univc-600 hover:text-univc-800">
                                        Gerar novos QR Codes <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($patrimonios->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $patrimonios->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
