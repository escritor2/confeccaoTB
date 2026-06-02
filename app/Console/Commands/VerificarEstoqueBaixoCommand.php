<?php

namespace App\Console\Commands;

use App\Support\EstoqueAlerta;
use Illuminate\Console\Command;

class VerificarEstoqueBaixoCommand extends Command
{
    protected $signature = 'estoque:verificar-baixo';

    protected $description = 'Envia notificações para itens com estoque abaixo do mínimo';

    public function handle(): int
    {
        $total = EstoqueAlerta::verificarTodos();

        $this->info("Alertas enviados para {$total} item(ns) com estoque baixo.");

        return self::SUCCESS;
    }
}
