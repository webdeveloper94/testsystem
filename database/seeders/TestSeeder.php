<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Question;

class TestSeeder extends Seeder
{
    public function run()
    {
        // Create a demo test
        $test = Test::create([
            'title' => 'Demo Test',
            'description' => 'This is a demo test to showcase the system functionality',
            'time_limit' => 30,
            'is_active' => true,
            'questions_per_test' => 5
        ]);

        // Create questions for the test
        $questions = [
            [
                'question_text' => 'What is the capital of Uzbekistan?',
                'option_a' => 'Tashkent',
                'option_b' => 'Samarkand',
                'option_c' => 'Bukhara',
                'option_d' => 'Khiva',
                'correct_option' => 'a',
                'explanation' => 'Tashkent is the capital city of Uzbekistan.',
            ],
            [
                'question_text' => 'Which of these is NOT a programming language?',
                'option_a' => 'Python',
                'option_b' => 'Java',
                'option_c' => 'Cobra',
                'option_d' => 'PHP',
                'correct_option' => 'c',
                'explanation' => 'Cobra is not a programming language.',
            ],
            [
                'question_text' => 'What is 2 + 2?',
                'option_a' => '3',
                'option_b' => '4',
                'option_c' => '5',
                'option_d' => '6',
                'correct_option' => 'b',
                'explanation' => 'Basic arithmetic: 2 + 2 = 4',
            ],
            [
                'question_text' => 'Which planet is known as the Red Planet?',
                'option_a' => 'Venus',
                'option_b' => 'Jupiter',
                'option_c' => 'Mars',
                'option_d' => 'Saturn',
                'correct_option' => 'c',
                'explanation' => 'Mars is known as the Red Planet due to its reddish appearance.',
            ],
            [
                'question_text' => 'Who wrote "Romeo and Juliet"?',
                'option_a' => 'Charles Dickens',
                'option_b' => 'William Shakespeare',
                'option_c' => 'Jane Austen',
                'option_d' => 'Mark Twain',
                'correct_option' => 'b',
                'explanation' => 'Romeo and Juliet was written by William Shakespeare.',
            ]
        ];

        foreach ($questions as $q) {
            Question::create([
                'test_id' => $test->id,
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_option' => $q['correct_option'],
                'explanation' => $q['explanation'],
                'points' => 1
            ]);
        }
    }
}
