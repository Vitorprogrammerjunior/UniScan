@extends('layouts.app')

@section('title', 'Gerenciar Usuários')
@section('header', 'Gerenciar Usuários')

@section('content')
<div class="space-y-6">
    <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded-r-lg">
        <div class="flex items-center">
            <i class="fas fa-user-shield text-purple-500 mr-2"></i>
            <p class="text-purple-700">
                <strong>Área Master</strong> - Gerencie os usuários que podem acessar o sistema. Todos têm acesso igual aos patrimônios.
            </p>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.master.usuarios.create') }}" 
           class="px-4 py-2 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Novo Usuário
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">E-mail</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Criado em</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($usuarios as $usuario)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-univc-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-univc-600 font-bold">{{ strtoupper(substr($usuario->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $usuario->name }}</p>
                                        @if($usuario->id === auth()->id())
                                            <span class="text-xs text-univc-600">(Você)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $usuario->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-sm">{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.master.usuarios.edit', $usuario) }}" 
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($usuario->id !== auth()->id())
                                        <form action="{{ route('admin.master.usuarios.destroy', $usuario) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Tem certeza que deseja excluir este usuário?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                Nenhum usuário encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="text-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left mr-1"></i> Voltar ao Dashboard
        </a>
    </div>
</div>
@endsection
