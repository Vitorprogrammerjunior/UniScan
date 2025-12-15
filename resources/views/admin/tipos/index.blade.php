@extends('layouts.app')

@section('title', 'Tipos de Patrimônio')
@section('header', 'Tipos de Patrimônio')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <p class="text-gray-500">Gerencie os tipos/categorias de patrimônios</p>
        <a href="{{ route('admin.tipos.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Novo Tipo
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Descrição</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Patrimônios</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($tipos as $tipo)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium text-gray-900">{{ $tipo->nome }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $tipo->descricao ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-univc-100 text-univc-800">
                                    {{ $tipo->patrimonios_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.tipos.edit', $tipo) }}" 
                                       class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.tipos.destroy', $tipo) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este tipo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-tags text-gray-400 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 mb-2">Nenhum tipo cadastrado</p>
                                    <a href="{{ route('admin.tipos.create') }}" class="text-univc-600 hover:text-univc-800">
                                        Criar novo tipo <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($tipos->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tipos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
