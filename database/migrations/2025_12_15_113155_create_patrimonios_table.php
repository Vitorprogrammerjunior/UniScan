<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patrimonios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_barra')->unique();
            $table->string('nome')->nullable();
            $table->foreignId('tipo_patrimonio_id')->nullable()->constrained('tipo_patrimonios')->nullOnDelete();
            $table->foreignId('local_armazenamento_id')->nullable()->constrained('local_armazenamentos')->nullOnDelete();
            $table->enum('situacao', ['disponivel', 'manutencao', 'emprestado', 'descartado', 'separado_descarte'])->default('disponivel');
            $table->boolean('cadastrado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrimonios');
    }
};
