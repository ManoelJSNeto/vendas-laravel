<?php

namespace App\Services;

class BoletoGenerator
{
    public static function generateBarcode(int $orderId, float $valor): string
    {
        $banco = '341';
        $moeda = '9';
        $fatorVencimento = str_pad((string) (now()->diffInDays('2000-07-03') + 10), 4, '0', STR_PAD_LEFT);
        $valorFormatado = str_pad((string) round($valor * 100), 10, '0', STR_PAD_LEFT);
        $campoLivre = str_pad((string) $orderId, 25, '0', STR_PAD_LEFT);

        $semDv = $banco.$moeda.$fatorVencimento.$valorFormatado.$campoLivre;
        $dv = self::modulo11($semDv);

        return substr($semDv, 0, 4).$dv.substr($semDv, 4);
    }

    public static function formatLinhaDigitavel(string $barcode): string
    {
        $campo1 = substr($barcode, 0, 4).substr($barcode, 19, 5);
        $campo2 = substr($barcode, 24, 10);
        $campo3 = substr($barcode, 34, 10);
        $dvGeral = substr($barcode, 4, 1);
        $campo4 = substr($barcode, 5, 14);

        return sprintf(
            '%s-%s %s-%s %s-%s %s %s-%s',
            substr($campo1, 0, 5), substr($campo1, 5, 4),
            substr($campo2, 0, 5), substr($campo2, 5, 5),
            substr($campo3, 0, 5), substr($campo3, 5, 5),
            $dvGeral,
            substr($campo4, 0, 10), substr($campo4, 10, 4)
        );
    }

    private static function modulo11(string $campo): string
    {
        $soma = 0;
        $peso = 2;

        for ($i = strlen($campo) - 1; $i >= 0; $i--) {
            $soma += (int) $campo[$i] * $peso;
            $peso = $peso === 9 ? 2 : $peso + 1;
        }

        $resto = $soma % 11;
        $dv = 11 - $resto;

        return ($dv === 0 || $dv === 1 || $dv === 10 || $dv === 11) ? '1' : (string) $dv;
    }
}