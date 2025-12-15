<?php

namespace App\Http\Controllers;

use App\Models\Patrimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function verificarPatrimonio($codigo)
    {
        $patrimonio = Patrimonio::where('codigo_barra', $codigo)
            ->with(['tipoPatrimonio', 'localArmazenamento'])
            ->first();

        // Se não existe, cria um registro pendente
        if (!$patrimonio) {
            $patrimonio = Patrimonio::create([
                'codigo_barra' => $codigo,
                'cadastrado' => false,
            ]);
        }

        // Se não está cadastrado, mostra tela de cadastro (precisa logar)
        if (!$patrimonio->cadastrado) {
            return view('public.patrimonio-nao-cadastrado', [
                'patrimonio' => $patrimonio,
                'isAdmin' => Auth::check(),
            ]);
        }

        // Patrimônio cadastrado - mostra informações públicas
        return view('public.patrimonio-detalhes', [
            'patrimonio' => $patrimonio,
            'isAdmin' => Auth::check(),
        ]);
    }
}
