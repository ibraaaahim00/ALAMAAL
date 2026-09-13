<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Specialist = 'specialist';
    case User = 'user';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'مدير النظام',
            self::Specialist => 'أخصائي',
            self::User => 'مستخدم',
        };
    }
}
