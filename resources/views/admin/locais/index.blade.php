@extends('layouts.app')

@section('title', 'Locais de Armazenamento')
@section('header', 'Locais de Armazenamento')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <p class="text-gray-500">Gerencie os locais de armazenamento dos patrimônios</p>
        <a href="{{ route('admin.locais.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Novo Local
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
                    @forelse($locais as $local)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium text-gray-900">{{ $local->nome }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $local->descricao ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-univc-100 text-univc-800">
                                    {{ $local->patrimonios_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.locais.edit', $local) }}" 
                                       class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.locais.destroy', $local) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este local?')">
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
                                        <i class="fas fa-location-dot text-gray-400 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 mb-2">Nenhum local cadastrado</p>
                                    <a href="{{ route('admin.locais.create') }}" class="text-univc-600 hover:text-univc-800">
                                        Criar novo local <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($locais->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $locais->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
