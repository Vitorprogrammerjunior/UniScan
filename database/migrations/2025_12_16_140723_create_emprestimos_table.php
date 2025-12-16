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
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patrimonio_id')->constrained('patrimonios')->onDelete('cascade');
            $table->foreignId('local_original_id')->constrained('local_armazenamentos')->onDelete('cascade');
            $table->foreignId('local_emprestado_id')->constrained('local_armazenamentos')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('data_emprestimo')->useCurrent();
            $table->timestamp('data_devolucao')->nullable();
            $table->boolean('devolvido')->default(false);
            $table->timestamps();
            
            $table->index(['patrimonio_id', 'devolvido']);
            $table->index('data_emprestimo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};
