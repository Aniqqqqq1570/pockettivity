<?php

namespace App\Support;

class MoneyFormatter
{
    public static function format(string|int|float|null $amount): string
    {
        return 'Rp'.self::localized($amount);
    }

    public static function forInput(string|int|float|null $amount): string
    {
        return self::localized($amount);
    }

    public static function formatCents(string|int|float|null $cents): string
    {
        $value = (string) ($cents ?? '0');
        $negative = str_starts_with($value, '-');
        $digits = preg_replace('/\D/', '', $value) ?: '0';
        $digits = str_pad($digits, 3, '0', STR_PAD_LEFT);
        $amount = substr($digits, 0, -2).'.'.substr($digits, -2);

        return 'Rp'.($negative ? '-' : '').self::localized($amount);
    }

    private static function localized(string|int|float|null $amount): string
    {
        $value = trim((string) ($amount ?? ''));

        if ($value === '') {
            return '';
        }

        $negative = str_starts_with($value, '-');
        $value = ltrim($value, '-+');

        if (str_contains($value, ',')) {
            [$whole, $fraction] = array_pad(explode(',', $value, 2), 2, '');
            $whole = str_replace('.', '', $whole);
        } elseif (substr_count($value, '.') > 1) {
            $whole = str_replace('.', '', $value);
            $fraction = '';
        } else {
            [$whole, $fraction] = array_pad(explode('.', $value, 2), 2, '');
        }

        $whole = preg_replace('/\D/', '', $whole) ?: '0';
        $whole = ltrim($whole, '0') ?: '0';
        $fraction = substr(preg_replace('/\D/', '', $fraction) ?: '', 0, 2);
        $fraction = substr(str_pad($fraction, 2, '0'), 0, 2);
        $whole = preg_replace('/\B(?=(\d{3})+(?!\d))/', '.', $whole);

        return ($negative ? '-' : '').$whole.($fraction === '00' ? '' : ','.$fraction);
    }
}
