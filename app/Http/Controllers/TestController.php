<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use App\Models\Question;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::where('is_active', true)->get();
        return view('tests.index', compact('tests'));
    }

    public function show(Test $test)
    {
        $questions = $test->questions()
            ->inRandomOrder()
            ->take($test->questions_per_test)
            ->get();

        return view('tests.show', compact('test', 'questions'));
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
            \Log::info('Test submission started', [
                'test_id' => $test->id,
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);

            $answers = $request->input('answers');
            $timeTaken = $request->input('time_taken');
            
            // Validate input
            if (empty($answers) || !is_array($answers)) {
                \Log::error('Invalid answers format', [
                    'answers' => $answers,
                    'type' => gettype($answers)
                ]);
                return response()->json(['error' => 'Invalid answers format'], 400);
            }
            
            if (!$timeTaken || !is_numeric($timeTaken)) {
                \Log::error('Invalid time_taken format', [
                    'time_taken' => $timeTaken,
                    'type' => gettype($timeTaken)
                ]);
                return response()->json(['error' => 'Invalid time taken format'], 400);
            }
            
            // Format answers for storage
            $formattedAnswers = [];
            foreach ($answers as $answer) {
                if (!isset($answer['question_id']) || !isset($answer['selected_option'])) {
                    \Log::error('Invalid answer format', ['answer' => $answer]);
                    return response()->json(['error' => 'Invalid answer format'], 400);
                }
                $formattedAnswers[$answer['question_id']] = $answer['selected_option'];
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
            
            // Save test result
            $result = TestResult::create([
                'user_id' => auth()->id(),
                'test_id' => $test->id,
                'score' => $score,
                'answers' => $formattedAnswers,
                'time_taken' => $timeTaken
            ]);
            
            \Log::info('Test result saved successfully', [
                'test_id' => $test->id,
                'user_id' => auth()->id(),
                'score' => $score,
                'result_id' => $result->id,
                'answers' => $formattedAnswers
            ]);
            
            return response()->json([
                'score' => $score,
                'correctAnswers' => $correctAnswers,
                'totalQuestions' => $totalQuestions,
                'timeTaken' => $timeTaken
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error saving test result', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'test_id' => $test->id,
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);
            
            return response()->json(['error' => 'An error occurred while saving the test result'], 500);
        }
    }

    public function results()
    {
        $results = TestResult::with('test')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('tests.results', compact('results'));
    }
}
