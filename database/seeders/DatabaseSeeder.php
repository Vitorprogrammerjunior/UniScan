<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar apenas o usuário admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@univc.edu.br',
            'password' => Hash::make('admin123'),
        ]);
    }
}
