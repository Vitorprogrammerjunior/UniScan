<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatrimonioController;
use App\Http\Controllers\TipoPatrimonioController;
use App\Http\Controllers\LocalArmazenamentoController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UsuarioController;

// Rota pública - verificar patrimônio via QR Code
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/patrimonio/{codigo}', [PublicController::class, 'verificarPatrimonio'])
    ->name('patrimonio.verificar');

// Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas (admin)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Patrimônios
    Route::get('/patrimonios/pendentes', [PatrimonioController::class, 'pendentes'])
        ->name('patrimonios.pendentes');
    Route::post('/patrimonios/{id}/cadastrar-pendente', [PatrimonioController::class, 'cadastrarPendente'])
        ->name('patrimonios.cadastrar-pendente');
    Route::resource('patrimonios', PatrimonioController::class);
    
    // Tipos de Patrimônio
    Route::resource('tipos', TipoPatrimonioController::class)->except(['show']);
    
    // Locais de Armazenamento
    Route::resource('locais', LocalArmazenamentoController::class)->except(['show']);
    
    // QR Codes
    Route::get('/qrcodes', [QrCodeController::class, 'index'])->name('qrcodes.index');
    Route::get('/qrcodes/pendentes', [QrCodeController::class, 'pendentes'])->name('qrcodes.pendentes');
    Route::post('/qrcodes/gerar', [QrCodeController::class, 'gerar'])->name('qrcodes.gerar');
    Route::post('/qrcodes/imprimir', [QrCodeController::class, 'imprimir'])->name('qrcodes.imprimir');
    Route::get('/qrcodes/svg/{codigo}', [QrCodeController::class, 'gerarUnico'])->name('qrcodes.unico');
    
    // Relatórios
    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
    Route::post('/relatorios/gerar', [RelatorioController::class, 'gerar'])->name('relatorios.gerar');
    
    // Rota secreta - Gerenciamento de Usuários (Admin Master)
    Route::prefix('master')->name('master.')->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/criar', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });
});
