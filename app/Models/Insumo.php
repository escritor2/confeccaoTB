<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = ['nome', 'unidade', 'quantidade', 'quantidade_minima', 'custo_unitario', 'observacoes'];

    protected $casts = [
        'custo_unitario' => 'decimal:2',
    ];

    public function estaAbaixoDoMinimo(): bool
    {
        return $this->quantidade <= $this->quantidade_minima;
    }
}
