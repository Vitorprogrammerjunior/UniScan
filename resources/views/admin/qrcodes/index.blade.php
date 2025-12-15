@extends('layouts.app')

@section('title', 'Gerar QR Codes')
@section('header', 'Gerar QR Codes')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                <i class="fas fa-qrcode text-univc-600 mr-2"></i>
                Gerador de QR Codes em Lote
            </h3>
            <p class="text-gray-500 text-sm">
                Gere QR Codes para etiquetas de patrimônio. Cada QR Code conterá uma URL única que, 
                ao ser escaneada, levará para a página do patrimônio.
            </p>
        </div>
        
        <form action="{{ route('admin.qrcodes.gerar') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="quantidade" class="block text-sm font-medium text-gray-700 mb-1">
                    Quantidade de QR Codes *
                </label>
                <input type="number" id="quantidade" name="quantidade" value="{{ old('quantidade', 10) }}" 
                       required min="1" max="100"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-univc-500 focus:border-univc-500"
                       placeholder="10">
                @error('quantidade')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="bg-univc-50 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-univc-600 mr-2 mt-0.5"></i>
                    <div class="text-sm text-univc-700">
                        <p class="mb-1">Os códigos serão gerados automaticamente a partir do último código existente.</p>
                        <p class="font-medium">Próximo código: <span class="font-mono">{{ $proximoCodigo }}</span></p>
                    </div>
                </div>
            </div>
            
            <button type="submit" 
                    class="w-full px-6 py-3 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors font-medium">
                <i class="fas fa-qrcode mr-2"></i> Gerar QR Codes
            </button>
        </form>
    </div>
    
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
        <div class="flex">
            <i class="fas fa-lightbulb text-yellow-500 mr-2 mt-1"></i>
            <div class="text-sm text-yellow-700">
                <p class="font-medium mb-1">Dica de uso:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Imprima os QR Codes e cole nos patrimônios</li>
                    <li>Quando alguém escanear, verá as informações ou poderá cadastrar (se for admin)</li>
                    <li>Os QR Codes nunca precisam ser atualizados!</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
