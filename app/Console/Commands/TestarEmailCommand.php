<?php

namespace App\Console\Commands;

use App\Support\MailConfiguration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestarEmailCommand extends Command
{
    protected $signature = 'mail:testar {email? : Destinatario do teste}';

    protected $description = 'Envia um e-mail de teste via SMTP real';

    public function handle(): int
    {
        $status = MailConfiguration::status();

        if (! $status['ready']) {
            $this->error('O e-mail real ainda nao esta pronto:');

            foreach ($status['issues'] as $issue) {
                $this->line('- '.$issue);
            }

            return self::FAILURE;
        }

        $destino = $this->argument('email') ?? config('mail.from.address');

        if (! $destino) {
            $this->error('Informe um e-mail ou configure MAIL_FROM_ADDRESS no .env');

            return self::FAILURE;
        }

        try {
            Mail::raw(
                'E-mail de teste do sistema '.config('app.name').' - SMTP configurado corretamente.',
                fn ($message) => $message->to($destino)->subject('Teste SMTP - '.config('app.name'))
            );
        } catch (\Throwable $e) {
            $this->error(MailConfiguration::describeFailure($e));

            return self::FAILURE;
        }

        $this->info("E-mail real enviado para {$destino}");

        return self::SUCCESS;
    }
}
