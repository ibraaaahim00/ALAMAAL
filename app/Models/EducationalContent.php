<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EducationalContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'slug',
        'title',
        'description',
        'target_category',
        'thumbnail',
        'video_url',
        'instructions',
        'guidance_steps',
        'published_at',
        'views_count',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'views_count' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($content) {
            if (empty($content->slug)) {
                $content->slug = Str::slug($content->title) ?: 'content-' . uniqid();
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }
        return asset($this->thumbnail);
    }

    public function getYoutubeEmbedUrlAttribute(): string
    {
        if (empty($this->video_url)) {
            return 'https://www.youtube.com/embed/dQw4w9WgXcQ';
        }

        // If it's already an embed url
        if (str_contains($this->video_url, 'youtube.com/embed/')) {
            return $this->video_url;
        }

        // Extract video ID from youtube.com/watch?v=... or youtu.be/...
        preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $this->video_url, $matches);
        $videoId = $matches[1] ?? 'dQw4w9WgXcQ';

        return 'https://www.youtube.com/embed/' . $videoId;
    }
}
