<?php

namespace App\Enums;

enum Currency: string
{
    case USD = 'USD';
    case KWD = 'KWD';
    case EGP = 'EGP';
    case SAR = 'SAR';

    public function symbol(): string
    {
        return match ($this) {
            self::USD => '$',
            self::KWD => 'KD',
            self::EGP => '£',
            self::SAR => 'SR',
        };
    }

    public function code(): string
    {
        return match ($this) {
            self::USD => 'USD',
            self::KWD => 'KWD',
            self::EGP => 'EGP',
            self::SAR => 'SAR',
        };
    }
}
