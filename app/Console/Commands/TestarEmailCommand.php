<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestarEmailCommand extends Command
{
    protected $signature = 'mail:testar {email? : Destinatário do teste}';

    protected $description = 'Envia um e-mail de teste via SMTP (Gmail)';

    public function handle(): int
    {
        $destino = $this->argument('email') ?? config('mail.from.address');

        if (! $destino) {
            $this->error('Informe um e-mail ou configure MAIL_FROM_ADDRESS no .env');

            return self::FAILURE;
        }

        try {
            Mail::raw(
                'E-mail de teste do sistema '.config('app.name').' — SMTP configurado corretamente.',
                fn ($message) => $message->to($destino)->subject('Teste SMTP — '.config('app.name'))
            );
        } catch (\Throwable $e) {
            $this->error('Falha ao enviar: '.$e->getMessage());

            return self::FAILURE;
        }

        $this->info("E-mail de teste enviado para {$destino}");

        return self::SUCCESS;
    }
}
