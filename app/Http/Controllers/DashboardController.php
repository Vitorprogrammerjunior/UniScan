<?php

namespace App\Http\Controllers;

use App\Models\Patrimonio;
use App\Models\TipoPatrimonio;
use App\Models\LocalArmazenamento;
use App\Models\LogPatrimonio;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Patrimonio::where('cadastrado', true)->count(),
            'disponiveis' => Patrimonio::where('cadastrado', true)->where('situacao', 'disponivel')->count(),
            'manutencao' => Patrimonio::where('cadastrado', true)->where('situacao', 'manutencao')->count(),
            'emprestados' => Patrimonio::where('cadastrado', true)->where('situacao', 'emprestado')->count(),
            'descartados' => Patrimonio::where('cadastrado', true)->where('situacao', 'descartado')->count(),
            'pendentes' => Patrimonio::where('cadastrado', false)->count(),
        ];

        $porTipo = TipoPatrimonio::withCount(['patrimonios' => function ($query) {
            $query->where('cadastrado', true);
        }])->get();

        $porLocal = LocalArmazenamento::withCount(['patrimonios' => function ($query) {
            $query->where('cadastrado', true);
        }])->get();

        $ultimosLogs = LogPatrimonio::with(['patrimonio', 'user'])
            ->latest()
            ->take(10)
            ->get();

        $ultimosPatrimonios = Patrimonio::with(['tipoPatrimonio', 'localArmazenamento'])
            ->where('cadastrado', true)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'porTipo',
            'porLocal',
            'ultimosLogs',
            'ultimosPatrimonios'
        ));
    }
}
