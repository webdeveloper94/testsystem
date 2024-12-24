<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Question;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    private function randomizeOptions(Question $question)
    {
        // Get all non-null options
        $options = [
            'a' => $question->option_a,
            'b' => $question->option_b,
            'c' => $question->option_c,
            'd' => $question->option_d
        ];
        
        // Remove null options
        $options = array_filter($options, function($value) {
            return !is_null($value);
        });
        
        // Get original correct answer value
        $correctAnswer = $options[$question->correct_option];
        
        // Shuffle options
        $values = array_values($options);
        shuffle($values);
        
        // Recreate options array with original keys
        $shuffledOptions = [];
        $keys = ['a', 'b', 'c', 'd'];
        foreach ($values as $i => $value) {
            $shuffledOptions[$keys[$i]] = $value;
        }
        
        // Find new position of correct answer
        $newCorrectOption = array_search($correctAnswer, $shuffledOptions);
        
        return [
            'options' => $shuffledOptions,
            'correct_option' => $newCorrectOption
        ];
    }

    public function index()
    {
        try {
            Log::info('Accessing tests index');
            $tests = Test::where('is_active', true)->get();
            Log::info('Tests retrieved', ['count' => $tests->count()]);
            
            return view('tests.index', [
                'tests' => $tests
            ]);
        } catch (\Exception $e) {
            Log::error('Error in tests index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error loading tests');
        }
    }

    public function show(Test $test)
    {
        try {
            // Get all questions for this test
            $allQuestions = $test->questions()->inRandomOrder()->get();
            
            // If questions_per_test is set and less than total questions, take only that many
            if ($test->questions_per_test && $test->questions_per_test < $allQuestions->count()) {
                $questions = $allQuestions->take($test->questions_per_test);
            } else {
                $questions = $allQuestions;
            }

            // Store the selected question IDs in session
            Session::put('test_'.$test->id.'_questions', $questions->pluck('id')->toArray());
            
            // Store correct answers in session
            $correctAnswers = [];
            foreach ($questions as $question) {
                $randomized = $this->randomizeOptions($question);
                $question->options = $randomized['options'];
                $correctAnswers[$question->id] = $randomized['correct_option'];
            }
            Session::put('test_'.$test->id.'_correct_answers', $correctAnswers);

            return view('tests.show', compact('test', 'questions'));
        } catch (\Exception $e) {
            Log::error('Error showing test', [
                'test_id' => $test->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Error loading test');
        }
    }

    public function checkAnswer(Request $request)
    {
        try {
            $questionId = $request->input('question_id');
            $selectedOption = $request->input('selected_option');
            
            $question = Question::findOrFail($questionId);
            
            // Get correct answer from session
            $correctAnswers = session('test_' . $question->test_id . '_correct_answers', []);
            $correctOption = $correctAnswers[$questionId] ?? null;
            
            if ($correctOption === null) {
                return response()->json(['error' => 'Question not found'], 404);
            }
            
            $isCorrect = $correctOption === $selectedOption;
            
            return response()->json([
                'correct' => $isCorrect,
                'correctOption' => $correctOption,
                'explanation' => $question->explanation ?? null
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function submit(Request $request, Test $test)
    {
        try {
            Log::info('Test submission started', [
                'test_id' => $test->id,
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);

            $answers = $request->input('answers');
            $timeTaken = $request->input('time_taken');
            
            if (empty($answers) || !is_array($answers)) {
                Log::error('Invalid answers format', [
                    'answers' => $answers,
                    'type' => gettype($answers)
                ]);
                return response()->json(['error' => 'Invalid answers format'], 400);
            }
            
            if (!$timeTaken || !is_numeric($timeTaken)) {
                Log::error('Invalid time_taken format', [
                    'time_taken' => $timeTaken,
                    'type' => gettype($timeTaken)
                ]);
                return response()->json(['error' => 'Invalid time taken format'], 400);
            }
            
            // Get selected question IDs from session
            $questionIds = Session::get('test_'.$test->id.'_questions', []);
            $correctAnswers = Session::get('test_'.$test->id.'_correct_answers', []);
            
            $totalQuestions = count($questionIds);
            $correctCount = 0;

            foreach ($questionIds as $questionId) {
                if (isset($answers[$questionId]) && isset($correctAnswers[$questionId])) {
                    if ($answers[$questionId] === $correctAnswers[$questionId]) {
                        $correctCount++;
                    }
                }
            }

            $score = $totalQuestions > 0 ? ($correctCount / $totalQuestions) * 100 : 0;

            // Save test result
            TestResult::create([
                'user_id' => auth()->id(),
                'test_id' => $test->id,
                'score' => $score,
                'answers' => $answers,
                'time_taken' => $timeTaken
            ]);

            // Clear session data
            Session::forget([
                'test_'.$test->id.'_questions',
                'test_'.$test->id.'_correct_answers'
            ]);

            return response()->json([
                'score' => $score,
                'correctAnswers' => $correctCount,
                'totalQuestions' => $totalQuestions,
                'timeTaken' => $timeTaken
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error saving test result', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'An error occurred while saving the test result'], 500);
        }
    }

    public function showSolution(Test $test, TestResult $result)
    {
        try {
            // Verify that the result belongs to the current user
            if ($result->user_id !== auth()->id()) {
                return back()->with('error', 'Unauthorized access to test solution');
            }

            // Get all questions for this test
            $questions = $test->questions()->get();
            
            // Get the user's answers from the result
            $userAnswers = $result->answers;
            
            return view('tests.solution', compact('test', 'questions', 'result', 'userAnswers'));
        } catch (\Exception $e) {
            Log::error('Error showing test solution', [
                'test_id' => $test->id,
                'result_id' => $result->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Error loading test solution');
        }
    }

    public function results()
    {
        try {
            $results = TestResult::with('test')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
                
            return view('tests.results', compact('results'));
        } catch (\Exception $e) {
            Log::error('Error showing results', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error loading results');
        }
    }
}
