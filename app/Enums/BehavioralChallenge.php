<?php

namespace App\Enums;

enum BehavioralChallenge: string
{
    case Hyperactivity = 'hyperactivity';
    case Aggression = 'aggression';
    case Shyness = 'shyness';

    public function label(): string
    {
        return match ($this) {
            self::Hyperactivity => 'فرط حركة',
            self::Aggression => 'عدوانية',
            self::Shyness => 'خجل اجتماعي',
        };
    }
}
