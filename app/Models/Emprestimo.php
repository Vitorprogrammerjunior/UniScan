<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    protected $fillable = [
        'patrimonio_id',
        'local_original_id',
        'local_emprestado_id',
        'user_id',
        'data_emprestimo',
        'data_devolucao',
        'devolvido',
    ];

    protected $casts = [
        'data_emprestimo' => 'datetime',
        'data_devolucao' => 'datetime',
        'devolvido' => 'boolean',
    ];

    public function patrimonio()
    {
        return $this->belongsTo(Patrimonio::class);
    }

    public function localOriginal()
    {
        return $this->belongsTo(LocalArmazenamento::class, 'local_original_id');
    }

    public function localEmprestado()
    {
        return $this->belongsTo(LocalArmazenamento::class, 'local_emprestado_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope para empréstimos ativos (não devolvidos)
    public function scopeAtivos($query)
    {
        return $query->where('devolvido', false);
    }

    // Scope para empréstimos do mês atual
    public function scopeDoMesAtual($query)
    {
        return $query->whereMonth('data_emprestimo', now()->month)
                     ->whereYear('data_emprestimo', now()->year);
    }
}
