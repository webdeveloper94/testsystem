<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'time_limit',
        'passing_score',
        'is_active',
        'questions_per_test'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function questionImages(): HasMany
    {
        return $this->hasMany(QuestionImage::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }
}
