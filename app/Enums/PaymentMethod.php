<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Visa = 'visa';
    case Mastercard = 'mastercard';
    case ApplePay = 'apple';
    case Mada = 'mada';

    public function label(): string
    {
        return match ($this) {
            self::Visa => 'Visa',
            self::Mastercard => 'Mastercard',
            self::ApplePay => 'Apple Pay',
            self::Mada => 'مدى',
        };
    }
}
