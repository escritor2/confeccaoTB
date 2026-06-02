<?php

namespace App\Traits;

trait MasksSensitiveData
{
    /**
     * Remove todos os caracteres não numéricos.
     */
    public function cleanInput($data): string
    {
        return preg_replace('/\D/', '', (string)$data);
    }

    /**
     * Aplica máscara em CPF: XXX.***.***-XX
     */
    public function maskCpf(string $numbers): ?string
    {
        if (strlen($numbers) !== 11) {
            return null;
        }
        return substr($numbers, 0, 3) . '...' . substr($numbers, -2);
    }

    /**
     * Aplica máscara em Telefone: (XX) XX***-XXXX
     * Regra: DDD + 2 primeiros + 4 últimos
     */
    public function maskPhone(string $numbers): ?string
    {
        $len = strlen($numbers);
        if (!in_array($len, [10, 11])) {
            return null;
        }

        $ddd = substr($numbers, 0, 2);
        $first2 = substr($numbers, 2, 2);
        $last4 = substr($numbers, -4);
        
        $maskLen = $len - 2 - 2 - 4;
        $mask = '...';

        return "({$ddd}) {$first2}{$mask}-{$last4}";
    }

    /**
     * Detecta automaticamente e aplica a máscara.
     */
    public function maskSensitiveValue($value): string
    {
        if (empty(trim((string)$value))) {
            return "—";
        }

        $original = (string)$value;
        $clean = $this->cleanInput($original);
        $len = strlen($clean);

        if ($len === 10) {
            return $this->maskPhone($clean) ?? $original;
        }

        if ($len === 11) {
            // Heurística baseada no formato original
            if (str_contains($original, '.')) {
                return $this->maskCpf($clean) ?? $original;
            }

            if (str_contains($original, '(') || str_contains($original, ')')) {
                return $this->maskPhone($clean) ?? $original;
            }

            // Heurística baseada no 3º dígito (Celulares no Brasil após DDD)
            if ($clean[2] === '9') {
                return $this->maskPhone($clean) ?? $original;
            }

            return $this->maskCpf($clean) ?? $original;
        }

        return $original;
    }
}
