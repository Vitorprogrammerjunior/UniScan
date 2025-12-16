<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\LocalArmazenamento;
use Illuminate\Http\Request;

class EmprestimoController extends Controller
{
    public function index(Request $request)
    {
        $query = Emprestimo::with(['patrimonio', 'localOriginal', 'localEmprestado', 'user'])
            ->ativos()
            ->orderBy('data_emprestimo', 'desc');

        // Filtros
        if ($request->filled('local_original')) {
            $query->where('local_original_id', $request->local_original);
        }

        if ($request->filled('local_destino')) {
            $query->where('local_emprestado_id', $request->local_destino);
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->whereHas('patrimonio', function ($q) use ($busca) {
                $q->where('codigo_barra', 'like', "%{$busca}%")
                  ->orWhere('nome', 'like', "%{$busca}%");
            });
        }

        $emprestimos = $query->paginate(15);
        $locais = LocalArmazenamento::orderBy('nome')->get();

        return view('admin.emprestimos.index', compact('emprestimos', 'locais'));
    }
}
