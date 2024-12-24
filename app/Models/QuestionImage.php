<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Test;

class QuestionImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'question_index',
        'image_path'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
