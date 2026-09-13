<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';           // قيد التعيين
    case InProgress = 'in_progress';     // جاري العمل
    case Completed = 'completed';       // تم الانتهاء
    case Cancelled = 'cancelled';       // ملغي

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'قيد التعيين',
            self::InProgress => 'جاري العمل',
            self::Completed => 'تم الانتهاء',
            self::Cancelled => 'ملغي',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'status-badge--pending',
            self::InProgress => 'status-badge--progress',
            self::Completed => 'status-badge--completed',
            self::Cancelled => 'status-badge--cancelled',
        };
    }
}
