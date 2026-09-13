<?php

namespace App\Enums;

enum IndependenceLevel: string
{
    case Dependent = 'dependent';
    case Partially = 'partially';
    case Independent = 'independent';

    public function label(): string
    {
        return match ($this) {
            self::Dependent => 'غير مستقل',
            self::Partially => 'مستقل جزئياً',
            self::Independent => 'مستقل كلياً',
        };
    }
}
