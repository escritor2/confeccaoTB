<?php

namespace App\Support;

use App\Models\estoque;
use App\Notifications\EstoqueBaixoNotification;
use App\Services\NotificacaoService;

class EstoqueAlerta
{
    public static function verificar(estoque $item): void
    {
        if (! $item->estaAbaixoDoMinimo()) {
            return;
        }

        NotificacaoService::enviarParaUsuarios(new EstoqueBaixoNotification($item));
    }

    public static function verificarTodos(): int
    {
        $enviados = 0;

        estoque::query()->each(function (estoque $item) use (&$enviados) {
            if ($item->estaAbaixoDoMinimo()) {
                NotificacaoService::enviarParaUsuarios(new EstoqueBaixoNotification($item));
                $enviados++;
            }
        });

        return $enviados;
    }
}
