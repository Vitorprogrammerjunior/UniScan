<?php

namespace App\Http\Controllers;

use App\Models\Patrimonio;
use App\Models\TipoPatrimonio;
use App\Models\LocalArmazenamento;
use App\Models\Emprestimo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function index()
    {
        $tipos = TipoPatrimonio::orderBy('nome')->get();
        $locais = LocalArmazenamento::orderBy('nome')->get();
        return view('admin.relatorios.index', compact('tipos', 'locais'));
    }

    public function gerar(Request $request)
    {
        $query = Patrimonio::with(['tipoPatrimonio', 'localArmazenamento'])
            ->where('cadastrado', true);

        // Aplicar filtros
        if ($request->filled('tipo')) {
            $query->where('tipo_patrimonio_id', $request->tipo);
        }

        if ($request->filled('local')) {
            $query->where('local_armazenamento_id', $request->local);
        }

        if ($request->filled('situacao')) {
            $query->where('situacao', $request->situacao);
        }

        $patrimonios = $query->orderBy('codigo_barra')->get();

        // Buscar empréstimos do mês atual
        $emprestimosDoMes = Emprestimo::with(['patrimonio', 'localOriginal', 'localEmprestado', 'user'])
            ->doMesAtual()
            ->orderBy('data_emprestimo', 'desc')
            ->get();

        $filtros = [
            'tipo' => $request->filled('tipo') ? TipoPatrimonio::find($request->tipo)?->nome : 'Todos',
            'local' => $request->filled('local') ? LocalArmazenamento::find($request->local)?->nome : 'Todos',
            'situacao' => $request->filled('situacao') ? $this->getSituacaoLabel($request->situacao) : 'Todas',
        ];

        $pdf = Pdf::loadView('admin.relatorios.pdf', compact('patrimonios', 'filtros', 'emprestimosDoMes'));
        
        return $pdf->download('relatorio-patrimonios-' . date('Y-m-d-His') . '.pdf');
    }

    private function getSituacaoLabel($situacao)
    {
        return match($situacao) {
            'disponivel' => 'Disponível',
            'manutencao' => 'Manutenção',
            'emprestado' => 'Emprestado',
            'descartado' => 'Descartado',
            'separado_descarte' => 'Separado p/ Descarte',
            default => $situacao,
        };
    }
}
