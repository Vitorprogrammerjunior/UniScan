<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patrimonio extends Model
{
    protected $fillable = [
        'codigo_barra',
        'nome',
        'tipo_patrimonio_id',
        'local_armazenamento_id',
        'situacao',
        'cadastrado',
    ];

    protected $casts = [
        'cadastrado' => 'boolean',
    ];

    public function tipoPatrimonio(): BelongsTo
    {
        return $this->belongsTo(TipoPatrimonio::class);
    }

    public function localArmazenamento(): BelongsTo
    {
        return $this->belongsTo(LocalArmazenamento::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(LogPatrimonio::class);
    }

    public function getSituacaoLabelAttribute(): string
    {
        return match($this->situacao) {
            'disponivel' => 'Disponível',
            'manutencao' => 'Manutenção',
            'emprestado' => 'Emprestado',
            'descartado' => 'Descartado',
            'separado_descarte' => 'Separado p/ Descarte',
            default => $this->situacao,
        };
    }
}
