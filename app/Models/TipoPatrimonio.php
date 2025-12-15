<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoPatrimonio extends Model
{
    protected $fillable = ['nome', 'descricao'];

    public function patrimonios(): HasMany
    {
        return $this->hasMany(Patrimonio::class);
    }
}
