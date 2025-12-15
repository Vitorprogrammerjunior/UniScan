<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('name')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.master.usuarios.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Não permitir excluir a si mesmo
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.master.usuarios.index')
                ->with('error', 'Você não pode excluir seu próprio usuário!');
        }

        $user->delete();

        return redirect()->route('admin.master.usuarios.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }
}
