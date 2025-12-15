<?php

namespace App\Http\Controllers;

use App\Models\TipoPatrimonio;
use Illuminate\Http\Request;

class TipoPatrimonioController extends Controller
{
    public function index()
    {
        $tipos = TipoPatrimonio::withCount('patrimonios')->orderBy('nome')->paginate(15);
        return view('admin.tipos.index', compact('tipos'));
    }

    public function create()
    {
        return view('admin.tipos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:tipo_patrimonios,nome',
            'descricao' => 'nullable|string|max:500',
        ]);

        TipoPatrimonio::create($validated);

        return redirect()->route('admin.tipos.index')
            ->with('success', 'Tipo de patrimônio criado com sucesso!');
    }

    public function edit(string $id)
    {
        $tipo = TipoPatrimonio::findOrFail($id);
        return view('admin.tipos.edit', compact('tipo'));
    }

    public function update(Request $request, string $id)
    {
        $tipo = TipoPatrimonio::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:tipo_patrimonios,nome,' . $id,
            'descricao' => 'nullable|string|max:500',
        ]);

        $tipo->update($validated);

        return redirect()->route('admin.tipos.index')
            ->with('success', 'Tipo de patrimônio atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $tipo = TipoPatrimonio::findOrFail($id);
        $tipo->delete();

        return redirect()->route('admin.tipos.index')
            ->with('success', 'Tipo de patrimônio excluído com sucesso!');
    }
}
