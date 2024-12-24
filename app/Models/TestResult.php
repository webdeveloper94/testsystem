<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Test;

class TestResult extends Model
{
    protected $fillable = [
        'user_id',
        'test_id',
        'score',
        'answers',
        'time_taken'
    ];

    protected $casts = [
        'answers' => 'array',
        'score' => 'float'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}
