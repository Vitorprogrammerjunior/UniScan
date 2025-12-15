<?php

namespace App\Http\Controllers;

use App\Models\LocalArmazenamento;
use Illuminate\Http\Request;

class LocalArmazenamentoController extends Controller
{
    public function index()
    {
        $locais = LocalArmazenamento::withCount('patrimonios')->orderBy('nome')->paginate(15);
        return view('admin.locais.index', compact('locais'));
    }

    public function create()
    {
        return view('admin.locais.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:local_armazenamentos,nome',
            'descricao' => 'nullable|string|max:500',
        ]);

        LocalArmazenamento::create($validated);

        return redirect()->route('admin.locais.index')
            ->with('success', 'Local de armazenamento criado com sucesso!');
    }

    public function edit(string $id)
    {
        $local = LocalArmazenamento::findOrFail($id);
        return view('admin.locais.edit', compact('local'));
    }

    public function update(Request $request, string $id)
    {
        $local = LocalArmazenamento::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:local_armazenamentos,nome,' . $id,
            'descricao' => 'nullable|string|max:500',
        ]);

        $local->update($validated);

        return redirect()->route('admin.locais.index')
            ->with('success', 'Local de armazenamento atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $local = LocalArmazenamento::findOrFail($id);
        $local->delete();

        return redirect()->route('admin.locais.index')
            ->with('success', 'Local de armazenamento excluído com sucesso!');
    }
}
