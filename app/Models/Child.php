<?php

namespace App\Models;

use App\Enums\BehavioralChallenge;
use App\Enums\ChildCondition;
use App\Enums\ChildGender;
use App\Enums\DesiredGoal;
use App\Enums\IndependenceLevel;
use App\Enums\SpeechLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'date_of_birth',
        'gender',
        'condition',
        'speech_level',
        'behavioral_challenge',
        'independence',
        'desired_goal',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'gender' => ChildGender::class,
            'condition' => ChildCondition::class,
            'speech_level' => SpeechLevel::class,
            'behavioral_challenge' => BehavioralChallenge::class,
            'independence' => IndependenceLevel::class,
            'desired_goal' => DesiredGoal::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
