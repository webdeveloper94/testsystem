<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\QuestionImage;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'explanation'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function image()
    {
        return $this->hasOne(QuestionImage::class);
    }

    public function getImage()
    {
        return QuestionImage::where('question_id', $this->id)->first();
    }
}
