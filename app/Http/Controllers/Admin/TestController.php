<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\QuestionImage;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->is_admin != 1) {
            return redirect('/dashboard');
        }

        $tests = Test::latest()->paginate(10);
        return view('admin.tests.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->is_admin != 1) {
            return redirect('/dashboard');
        }

        return view('admin.tests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->is_admin != 1) {
            return redirect('/dashboard');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
            'questions_per_test' => 'required|integer|min:1',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*' => 'required|string',
            'questions.*.correct_answer' => 'required|integer|min:0',
            'questions.*.image' => 'nullable|image|max:2048'
        ]);

        // Create test first
        $test = Test::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'time_limit' => $validated['time_limit'],
            'passing_score' => $validated['passing_score'],
            'is_active' => $validated['is_active'] ?? false,
            'questions_per_test' => $validated['questions_per_test'],
            'questions' => '[]' // Temporary empty array
        ]);

        // Handle question images and update questions array
        $questions = $validated['questions'];
        foreach ($request->file('questions', []) as $index => $questionData) {
            if (isset($questionData['image'])) {
                $path = $questionData['image']->store('question_images', 'public');
                
                // Create question image record with test_id
                QuestionImage::create([
                    'test_id' => $test->id,
                    'image_path' => $path,
                    'question_index' => $index
                ]);

                // Add image path to questions array
                $questions[$index]['image_path'] = $path;
            }
        }

        // Update test with questions
        $test->update([
            'questions' => json_encode($questions)
        ]);

        return redirect()->route('admin.tests.index')
            ->with('success', 'Test created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (auth()->user()->is_admin != 1) {
            return redirect('/dashboard');
        }

        $test = Test::findOrFail($id);
        return view('admin.tests.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->is_admin != 1) {
            return redirect('/dashboard');
        }

        $test = Test::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
            'questions_per_test' => 'required|integer|min:1'
        ]);

        $test->update($validated);

        return redirect()->route('admin.tests.index')
            ->with('success', 'Test updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->is_admin != 1) {
            return redirect('/dashboard');
        }

        $test = Test::findOrFail($id);
        $test->delete();

        return redirect()->route('admin.tests.index')
            ->with('success', 'Test deleted successfully.');
    }
}
