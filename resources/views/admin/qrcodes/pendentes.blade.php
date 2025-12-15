@extends('layouts.app')

@section('title', 'QR Codes Pendentes')
@section('header', 'QR Codes Pendentes')

@section('content')
<div class="space-y-6">
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
        <div class="flex items-center">
            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
            <p class="text-blue-700">
                Estes são QR Codes já gerados mas que ainda não foram vinculados a um patrimônio cadastrado.
                Selecione os que deseja imprimir.
            </p>
        </div>
    </div>
    
    @if($patrimonios->count() > 0)
        <form action="{{ route('admin.qrcodes.imprimir') }}" method="POST">
            @csrf
            
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-univc-600 rounded focus:ring-univc-500">
                            <span class="text-sm text-gray-600">Selecionar todos</span>
                        </label>
                    </div>
                    <button type="submit" 
                            class="px-4 py-2 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors">
                        <i class="fas fa-print mr-2"></i> Imprimir Selecionados
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-16">
                                    <span class="sr-only">Selecionar</span>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Código</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Criado em</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">QR Code</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($patrimonios as $patrimonio)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" 
                                               name="codigos[]" 
                                               value="{{ $patrimonio->codigo_barra }}"
                                               class="codigo-checkbox w-4 h-4 text-univc-600 rounded focus:ring-univc-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono text-sm font-medium text-univc-600">{{ $patrimonio->codigo_barra }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                            <i class="fas fa-clock mr-1"></i> Pendente
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $patrimonio->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <img src="{{ route('admin.qrcodes.unico', $patrimonio->codigo_barra) }}" 
                                             alt="QR Code {{ $patrimonio->codigo_barra }}"
                                             class="w-16 h-16 mx-auto">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('patrimonio.verificar', $patrimonio->codigo_barra) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-univc-600 text-white text-sm rounded-lg hover:bg-univc-700 transition-colors">
                                            <i class="fas fa-edit mr-1"></i> Cadastrar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($patrimonios->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $patrimonios->links() }}
                    </div>
                @endif
            </div>
        </form>
    @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-green-500 text-2xl"></i>
            </div>
            <p class="text-gray-500 mb-4">Nenhum QR Code pendente!</p>
            <a href="{{ route('admin.qrcodes.index') }}" class="text-univc-600 hover:text-univc-800">
                Gerar novos QR Codes <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.codigo-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endpush
@endsection
