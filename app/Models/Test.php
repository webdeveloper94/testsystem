<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\QuestionImage;
use App\Models\TestResult;
use App\Models\Question;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'questions',
        'time_limit',
        'is_active',
        'questions_per_test'
    ];

    protected $casts = [
        'questions' => 'array',
        'is_active' => 'boolean'
    ];

    public function images()
    {
        return $this->hasMany(QuestionImage::class);
    }

    public function results()
    {
        return $this->hasMany(TestResult::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
