<?php

namespace App\Support;

use Throwable;

class MailConfiguration
{
    public static function status(): array
    {
        $mailer = (string) config('mail.default');
        $from = (string) config('mail.from.address');
        $host = (string) config('mail.mailers.smtp.host');
        $port = (string) config('mail.mailers.smtp.port');
        $username = (string) config('mail.mailers.smtp.username');
        $password = (string) config('mail.mailers.smtp.password');
        $encryption = (string) config('mail.mailers.smtp.encryption');

        $issues = [];

        if (in_array($mailer, ['log', 'array'], true)) {
            $issues[] = 'O mailer atual apenas registra mensagens e nao entrega e-mails reais.';
        }

        if ($mailer === 'smtp') {
            if ($host === '') {
                $issues[] = 'MAIL_HOST nao foi configurado.';
            }

            if ($username === '' || self::isPlaceholder($username)) {
                $issues[] = 'MAIL_USERNAME precisa ser um e-mail SMTP real.';
            }

            if ($password === '' || self::isPlaceholder($password)) {
                $issues[] = 'MAIL_PASSWORD precisa ser a senha SMTP ou senha de app.';
            }
        }

        if ($from === '' || self::isPlaceholder($from) || ! filter_var($from, FILTER_VALIDATE_EMAIL)) {
            $issues[] = 'MAIL_FROM_ADDRESS precisa ser um e-mail valido.';
        }

        return [
            'mailer' => $mailer,
            'host' => $host,
            'port' => $port,
            'encryption' => $encryption,
            'from' => $from,
            'username' => $username,
            'password_set' => $password !== '' && ! self::isPlaceholder($password),
            'ready' => $issues === [],
            'issues' => $issues,
        ];
    }

    public static function isReadyForRealDelivery(): bool
    {
        return self::status()['ready'];
    }

    public static function describeFailure(Throwable $exception): string
    {
        $message = $exception->getMessage();
        $lowerMessage = strtolower($message);

        if (str_contains($lowerMessage, '535') || str_contains($lowerMessage, 'badcredentials')) {
            return 'O Gmail recusou o login SMTP. Confira se MAIL_USERNAME e MAIL_FROM_ADDRESS usam o mesmo e-mail e coloque em MAIL_PASSWORD uma senha de app do Google, nao a senha normal da conta.';
        }

        if (str_contains($lowerMessage, 'failed to authenticate')) {
            return 'O servidor SMTP recusou a autenticacao. Revise usuario, senha SMTP, host, porta e criptografia no arquivo .env.';
        }

        if (str_contains($lowerMessage, 'connection') || str_contains($lowerMessage, 'timed out')) {
            return 'Nao foi possivel conectar ao servidor SMTP. Confira MAIL_HOST, MAIL_PORT, MAIL_ENCRYPTION e a conexao de rede.';
        }

        return 'Falha ao enviar e-mail. Revise a configuracao SMTP no arquivo .env e tente novamente.';
    }

    private static function isPlaceholder(string $value): bool
    {
        $normalized = strtolower(trim($value));

        return in_array($normalized, [
            'seu_email@gmail.com',
            'sua_senha_de_app',
            'hello@example.com',
            'example@example.com',
        ], true);
    }
}
