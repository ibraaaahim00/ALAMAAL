<?php

namespace App\Enums;

enum ServiceType: string
{
    case Autism = 'autism';
    case DownSyndrome = 'down';
    case Consultation = 'consultation';

    public function label(): string
    {
        return match ($this) {
            self::Autism => 'أطفال التوحد',
            self::DownSyndrome => 'متلازمة داون',
            self::Consultation => 'الاستشارات',
        };
    }
}
