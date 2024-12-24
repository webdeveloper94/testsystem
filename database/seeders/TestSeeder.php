<?php

namespace Database\Seeders;

use App\Models\Test;
use App\Models\Question;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        // Create a sample test
        $test = Test::create([
            'title' => 'Sample Math Test',
            'description' => 'A basic mathematics test covering arithmetic and algebra.',
            'time_limit' => 30,
            'passing_score' => 70,
        ]);

        // Create questions for the test
        $questions = [
            [
                'question_text' => 'What is 2 + 2?',
                'option_a' => '3',
                'option_b' => '4',
                'option_c' => '5',
                'option_d' => '6',
                'correct_option' => 'b',
            ],
            [
                'question_text' => 'Solve for x: 2x + 4 = 10',
                'option_a' => '2',
                'option_b' => '3',
                'option_c' => '4',
                'option_d' => '5',
                'correct_option' => 'b',
            ],
            [
                'question_text' => 'What is 5 × 7?',
                'option_a' => '30',
                'option_b' => '35',
                'option_c' => '40',
                'option_d' => '45',
                'correct_option' => 'b',
            ],
        ];

        foreach ($questions as $q) {
            $test->questions()->create($q);
        }
    }
}
