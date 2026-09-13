<?php

namespace App\Enums;

enum SpeechLevel: string
{
    case None = 'none';
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function label(): string
    {
        return match ($this) {
            self::None => 'لا ينطق',
            self::Low => 'كلمات بسيطة',
            self::Medium => 'جمل قصيرة',
            self::High => 'يتحدث بطلاقة',
        };
    }
}
