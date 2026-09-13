<?php

namespace App\Enums;

enum DesiredGoal: string
{
    case Communication = 'communication';
    case Behavior = 'behavior';
    case Skills = 'skills';

    public function label(): string
    {
        return match ($this) {
            self::Communication => 'تحسين التواصل',
            self::Behavior => 'تعديل السلوك',
            self::Skills => 'تطوير المهارات',
        };
    }
}
