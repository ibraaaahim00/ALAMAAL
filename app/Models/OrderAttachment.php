<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class OrderAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getUrlAttribute(): string
    {
        if (str_starts_with($this->file_path, 'http')) {
            return $this->file_path;
        }
        return Storage::disk('public')->url($this->file_path);
    }

    public function getIconClassAttribute(): string
    {
        return match ($this->file_type) {
            'image' => 'fa-image',
            'pdf' => 'fa-file-pdf',
            'video' => 'fa-video',
            default => 'fa-file-alt',
        };
    }
}
