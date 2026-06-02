<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estoque extends Model
{
    protected $fillable = ['nome', 'quantidade', 'quantidade_minima'];

    public function limiteMinimo(): int
    {
        return (int) ($this->quantidade_minima ?? config('notificacoes.estoque_limite_padrao'));
    }

    public function estaAbaixoDoMinimo(): bool
    {
        return $this->quantidade <= $this->limiteMinimo();
    }
}
