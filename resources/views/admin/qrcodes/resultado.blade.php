@extends('layouts.app')

@section('title', 'QR Codes Gerados')
@section('header', 'QR Codes Gerados')

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .print-area, .print-area * {
            visibility: visible;
        }
        .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 5mm;
        }
        .no-print {
            display: none !important;
        }
        .qr-item {
            page-break-inside: avoid;
            break-inside: avoid;
            border: 1px dashed #ccc !important;
            padding: 2mm !important;
            margin: 1mm !important;
        }
        .print-grid {
            display: grid !important;
            grid-template-columns: repeat(6, 1fr) !important;
            gap: 2mm !important;
        }
        .qr-print-img {
            width: 18mm !important;
            height: 18mm !important;
        }
        .qr-print-code {
            font-size: 7pt !important;
            margin-top: 1mm !important;
        }
        .qr-print-label {
            font-size: 5pt !important;
        }
    }
    
    .qr-svg-container svg {
        width: 100%;
        height: 100%;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between no-print">
        <div>
            <p class="text-gray-500">{{ count($qrcodes) }} QR Codes</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.qrcodes.index') }}" 
               class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
            <button onclick="window.print()" 
                    class="px-4 py-2 bg-univc-600 text-white rounded-lg hover:bg-univc-700 transition-colors">
                <i class="fas fa-print mr-2"></i> Imprimir
            </button>
        </div>
    </div>
    
    @if($criados > 0 || $existentes > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 no-print">
            @if($criados > 0)
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-plus-circle text-green-500 mr-2"></i>
                        <p class="text-green-700">
                            <strong>{{ $criados }}</strong> novos patrimônios criados (pendentes de cadastro)
                        </p>
                    </div>
                </div>
            @endif
            
            @if($existentes > 0)
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <p class="text-blue-700">
                            <strong>{{ $existentes }}</strong> já existiam no sistema
                        </p>
                    </div>
                </div>
            @endif
        </div>
    @endif
    
    <div class="bg-univc-50 border-l-4 border-univc-500 p-4 rounded-r-lg no-print">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-univc-600 mr-2"></i>
            <p class="text-univc-700 text-sm">
                <strong>QR Codes salvos!</strong> Você pode imprimi-los novamente a qualquer momento na seção 
                <a href="{{ route('admin.qrcodes.pendentes') }}" class="underline font-medium">QR Codes Pendentes</a>.
            </p>
        </div>
    </div>
    
    <div class="print-area bg-white rounded-xl shadow-sm p-6">
        <div class="print-grid grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-3">
            @foreach($qrcodes as $qr)
                <div class="qr-item flex flex-col items-center p-2 border border-gray-200 rounded-lg">
                    <div class="qr-svg-container qr-print-img w-20 h-20">
                        <img src="{{ route('admin.qrcodes.unico', $qr['codigo']) }}" 
                             alt="QR Code {{ $qr['codigo'] }}" 
                             class="w-full h-full">
                    </div>
                    <p class="qr-print-code font-mono text-xs font-bold text-gray-800 mt-1">{{ $qr['codigo'] }}</p>
                    <p class="qr-print-label text-[10px] text-gray-500">UNIVC</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
