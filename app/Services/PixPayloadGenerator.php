<?php

namespace App\Services;

class PixPayloadGenerator
{
    public static function generate(string $chavePix, string $nomeRecebedor, string $cidade, float $valor, string $txId): string
    {
        $payload = self::field('00', '01');
        $payload .= self::field('26', self::field('00', 'br.gov.bcb.pix').self::field('01', $chavePix));
        $payload .= self::field('52', '0000');
        $payload .= self::field('53', '986');
        $payload .= self::field('54', number_format($valor, 2, '.', ''));
        $payload .= self::field('58', 'BR');
        $payload .= self::field('59', substr(self::normalize($nomeRecebedor), 0, 25));
        $payload .= self::field('60', substr(self::normalize($cidade), 0, 15));
        $payload .= self::field('62', self::field('05', substr($txId, 0, 25)));
        $payload .= '6304';

        return $payload.self::crc16($payload);
    }

    private static function field(string $id, string $value): string
    {
        $length = str_pad((string) strlen($value), 2, '0', STR_PAD_LEFT);

        return $id.$length.$value;
    }

    private static function normalize(string $text): string
    {
        $text = preg_replace('/[^A-Za-z0-9 ]/', '', $text);

        return strtoupper(trim($text));
    }

    private static function crc16(string $payload): string
    {
        $polinomio = 0x1021;
        $resultado = 0xFFFF;

        for ($i = 0; $i < strlen($payload); $i++) {
            $resultado ^= (ord($payload[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                $resultado = ($resultado & 0x8000) ? (($resultado << 1) ^ $polinomio) : ($resultado << 1);
                $resultado &= 0xFFFF;
            }
        }

        return strtoupper(str_pad(dechex($resultado), 4, '0', STR_PAD_LEFT));
    }
}