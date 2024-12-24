<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\Question;
use App\Models\QuestionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tests = Test::latest()->paginate(10);
        return view('admin.tests.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'time_limit' => 'required|integer|min:1',
            'questions_per_test' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.correct_answer' => 'required|integer|min:0|max:3',
            'questions.*.answers' => 'required|array|size:4',
            'questions.*.answers.*' => 'required|string',
            'questions.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Create test
            $test = Test::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'time_limit' => $validated['time_limit'],
                'questions_per_test' => $validated['questions_per_test'],
                'is_active' => $request->has('is_active')
            ]);

            // Create questions
            foreach ($validated['questions'] as $index => $questionData) {
                // Handle image upload
                if ($request->hasFile("questions.{$index}.image")) {
                    $image = $request->file("questions.{$index}.image");
                    $imagePath = $image->store('question_images', 'public');
                    
                    // Create question image
                    QuestionImage::create([
                        'test_id' => $test->id,
                        'question_index' => $index,
                        'image_path' => $imagePath
                    ]);
                }

                // Convert numeric correct answer (0-3) to letter (a-d)
                $correctOption = chr(97 + $questionData['correct_answer']); // 0->a, 1->b, 2->c, 3->d

                // Create question with options
                $question = $test->questions()->create([
                    'question_text' => $questionData['text'],
                    'option_a' => $questionData['answers'][0],
                    'option_b' => $questionData['answers'][1],
                    'option_c' => $questionData['answers'][2],
                    'option_d' => $questionData['answers'][3],
                    'correct_option' => $correctOption
                ]);
            }

            DB::commit();
            return redirect()->route('admin.tests.index')->with('success', 'Test created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating test: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Test $test)
    {
        $test->load(['questions', 'questionImages']);
        return view('admin.tests.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'time_limit' => 'required|integer|min:1',
            'questions_per_test' => 'required|integer|min:1'
        ]);

        $test->update($validated + ['is_active' => $request->has('is_active')]);

        return redirect()->route('admin.tests.index')
            ->with('success', 'Test updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        // Delete question images from storage
        foreach ($test->questionImages as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $test->delete();
        return redirect()->route('admin.tests.index')
            ->with('success', 'Test deleted successfully.');
    }
}
