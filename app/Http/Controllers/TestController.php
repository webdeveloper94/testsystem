<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Question;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function index()
    {
        try {
            Log::info('Accessing tests index');
            $tests = Test::all();
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
            $questions = $test->questions()
                ->inRandomOrder()
                ->take($test->questions_per_test)
                ->get();

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
        $questionId = $request->input('question_id');
        $selectedOption = $request->input('selected_option');
        
        $question = Question::findOrFail($questionId);
        $isCorrect = $question->correct_option === $selectedOption;
        
        return response()->json([
            'correct' => $isCorrect,
            'correctOption' => $question->correct_option,
            'explanation' => $question->explanation ?? null
        ]);
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
            
            $formattedAnswers = [];
            foreach ($answers as $questionId => $selectedOption) {
                $formattedAnswers[$questionId] = $selectedOption;
            }
            
            // Calculate score
            $totalQuestions = count($formattedAnswers);
            $correctAnswers = 0;
            
            foreach ($formattedAnswers as $questionId => $selectedOption) {
                $question = Question::find($questionId);
                if ($question && $question->correct_option === $selectedOption) {
                    $correctAnswers++;
                }
            }
            
            $score = ($correctAnswers / $totalQuestions) * 100;
            
            $result = TestResult::create([
                'user_id' => auth()->id(),
                'test_id' => $test->id,
                'score' => $score,
                'answers' => $formattedAnswers,
                'time_taken' => $timeTaken
            ]);
            
            Log::info('Test result saved', [
                'result_id' => $result->id,
                'score' => $score
            ]);
            
            return response()->json([
                'score' => $score,
                'correctAnswers' => $correctAnswers,
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
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Error loading test results');
        }
    }
}
