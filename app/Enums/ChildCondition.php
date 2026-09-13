<?php

namespace App\Enums;

enum ChildCondition: string
{
    case Autism = 'autism';
    case DownSyndrome = 'down';

    public function label(): string
    {
        return match ($this) {
            self::Autism => 'طيف توحد',
            self::DownSyndrome => 'متلازمة داون',
        };
    }
}
