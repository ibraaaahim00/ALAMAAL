<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'thumbnail',
        'video_url',
        'year',
        'month',
        'published_at',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'published_at' => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }
        return asset($this->thumbnail);
    }
}
