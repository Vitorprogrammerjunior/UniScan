<?php

namespace App\Http\Controllers;

use App\Models\Patrimonio;
use App\Models\TipoPatrimonio;
use App\Models\LocalArmazenamento;
use App\Models\LogPatrimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatrimonioController extends Controller
{
    public function index(Request $request)
    {
        $query = Patrimonio::with(['tipoPatrimonio', 'localArmazenamento'])
            ->where('cadastrado', true);

        // Filtros
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('codigo_barra', 'like', "%{$busca}%")
                  ->orWhere('nome', 'like', "%{$busca}%");
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo_patrimonio_id', $request->tipo);
        }

        if ($request->filled('local')) {
            $query->where('local_armazenamento_id', $request->local);
        }

        if ($request->filled('situacao')) {
            $query->where('situacao', $request->situacao);
        }

        $patrimonios = $query->orderBy('codigo_barra')->paginate(15);
        $tipos = TipoPatrimonio::orderBy('nome')->get();
        $locais = LocalArmazenamento::orderBy('nome')->get();

        return view('admin.patrimonios.index', compact('patrimonios', 'tipos', 'locais'));
    }

    public function pendentes()
    {
        $patrimonios = Patrimonio::where('cadastrado', false)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.patrimonios.pendentes', compact('patrimonios'));
    }

    public function create()
    {
        $tipos = TipoPatrimonio::orderBy('nome')->get();
        $locais = LocalArmazenamento::orderBy('nome')->get();
        return view('admin.patrimonios.create', compact('tipos', 'locais'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_barra' => 'required|string|unique:patrimonios,codigo_barra',
            'nome' => 'required|string|max:255',
            'tipo_patrimonio_id' => 'required|exists:tipo_patrimonios,id',
            'local_armazenamento_id' => 'required|exists:local_armazenamentos,id',
            'situacao' => 'required|in:disponivel,manutencao,emprestado,descartado,separado_descarte',
        ]);

        $validated['cadastrado'] = true;

        $patrimonio = Patrimonio::create($validated);

        LogPatrimonio::create([
            'patrimonio_id' => $patrimonio->id,
            'user_id' => Auth::id(),
            'acao' => 'Cadastro',
            'detalhes' => 'Patrimônio cadastrado no sistema',
        ]);

        return redirect()->route('admin.patrimonios.index')
            ->with('success', 'Patrimônio cadastrado com sucesso!');
    }

    public function show(string $id)
    {
        $patrimonio = Patrimonio::with(['tipoPatrimonio', 'localArmazenamento', 'logs.user'])
            ->findOrFail($id);

        return view('admin.patrimonios.show', compact('patrimonio'));
    }

    public function edit(string $id)
    {
        $patrimonio = Patrimonio::findOrFail($id);
        $tipos = TipoPatrimonio::orderBy('nome')->get();
        $locais = LocalArmazenamento::orderBy('nome')->get();

        return view('admin.patrimonios.edit', compact('patrimonio', 'tipos', 'locais'));
    }

    public function update(Request $request, string $id)
    {
        $patrimonio = Patrimonio::findOrFail($id);

        // Validação diferente se vier da página pública (sem codigo_barra)
        if ($request->has('redirect_to')) {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'tipo_patrimonio_id' => 'required|exists:tipo_patrimonios,id',
                'local_armazenamento_id' => 'required|exists:local_armazenamentos,id',
                'situacao' => 'required|in:disponivel,manutencao,emprestado,descartado,separado_descarte',
            ]);
        } else {
            $validated = $request->validate([
                'codigo_barra' => 'required|string|unique:patrimonios,codigo_barra,' . $id,
                'nome' => 'required|string|max:255',
                'tipo_patrimonio_id' => 'required|exists:tipo_patrimonios,id',
                'local_armazenamento_id' => 'required|exists:local_armazenamentos,id',
                'situacao' => 'required|in:disponivel,manutencao,emprestado,descartado,separado_descarte',
            ]);
        }

        $changes = [];
        foreach ($validated as $key => $value) {
            if ($patrimonio->$key != $value) {
                $changes[] = ucfirst(str_replace('_', ' ', $key)) . ": {$patrimonio->$key} → {$value}";
            }
        }

        $validated['cadastrado'] = true;
        $patrimonio->update($validated);

        if (!empty($changes)) {
            LogPatrimonio::create([
                'patrimonio_id' => $patrimonio->id,
                'user_id' => Auth::id(),
                'acao' => 'Atualização',
                'detalhes' => implode('; ', $changes),
            ]);
        }

        // Se veio de uma página pública (QR Code), redireciona de volta
        if ($request->has('redirect_to')) {
            return redirect($request->redirect_to)
                ->with('success', 'Patrimônio atualizado com sucesso!');
        }

        return redirect()->route('admin.patrimonios.index')
            ->with('success', 'Patrimônio atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $patrimonio = Patrimonio::findOrFail($id);
        $patrimonio->delete();

        return redirect()->route('admin.patrimonios.index')
            ->with('success', 'Patrimônio excluído com sucesso!');
    }

    // Cadastrar patrimônio pendente (via QR Code)
    public function cadastrarPendente(Request $request, string $id)
    {
        $patrimonio = Patrimonio::where('cadastrado', false)->findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo_patrimonio_id' => 'required|exists:tipo_patrimonios,id',
            'local_armazenamento_id' => 'required|exists:local_armazenamentos,id',
            'situacao' => 'required|in:disponivel,manutencao,emprestado,descartado,separado_descarte',
        ]);

        $validated['cadastrado'] = true;
        $patrimonio->update($validated);

        LogPatrimonio::create([
            'patrimonio_id' => $patrimonio->id,
            'user_id' => Auth::id(),
            'acao' => 'Cadastro via QR Code',
            'detalhes' => 'Patrimônio cadastrado através da leitura do QR Code',
        ]);

        return redirect()->route('patrimonio.verificar', $patrimonio->codigo_barra)
            ->with('success', 'Patrimônio cadastrado com sucesso!');
    }
}
