@extends('layouts.admin', ['title' => 'Create Test'])

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Create New Test</h1>
        <a href="{{ route('admin.tests.index') }}" class="text-indigo-600 hover:text-indigo-900">
            <i class="fas fa-arrow-left mr-2"></i> Back to Tests
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('admin.tests.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="time_limit" class="block text-gray-700 text-sm font-bold mb-2">Time Limit (minutes)</label>
                    <input type="number" name="time_limit" id="time_limit" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('time_limit') border-red-500 @enderror" value="{{ old('time_limit', 30) }}" required min="1">
                    @error('time_limit')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="passing_score" class="block text-gray-700 text-sm font-bold mb-2">Passing Score (%)</label>
                    <input type="number" name="passing_score" id="passing_score" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('passing_score') border-red-500 @enderror" value="{{ old('passing_score', 70) }}" required min="0" max="100">
                    @error('passing_score')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="questions_per_test" class="block text-gray-700 text-sm font-bold mb-2">Questions Per Test</label>
                <input type="number" name="questions_per_test" id="questions_per_test" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('questions_per_test') border-red-500 @enderror" value="{{ old('questions_per_test', 10) }}" required>
                @error('questions_per_test')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" class="form-checkbox h-4 w-4 text-indigo-600" value="1" {{ old('is_active') ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700">Active</span>
                </label>
            </div>

            <!-- Questions Section -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Questions</h3>
                <div id="questions-container">
                    <!-- Questions will be added here dynamically -->
                </div>
                <button type="button" id="add-question" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Add Question
                </button>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                    Create Test
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let questionCount = 0;

    function addQuestion() {
        const container = document.getElementById('questions-container');
        const questionDiv = document.createElement('div');
        questionDiv.className = 'mb-6 p-4 border rounded-lg';
        questionDiv.innerHTML = `
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-medium">Question ${questionCount + 1}</h4>
                <button type="button" onclick="this.closest('.mb-6').remove()" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Question Text</label>
                <textarea name="questions[${questionCount}][question]" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Question Image (optional)</label>
                <input type="file" name="questions[${questionCount}][image]" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Options</label>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <input type="radio" name="questions[${questionCount}][correct_answer]" value="0" required class="mr-2">
                        <input type="text" name="questions[${questionCount}][options][]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Option 1" required>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="questions[${questionCount}][correct_answer]" value="1" class="mr-2">
                        <input type="text" name="questions[${questionCount}][options][]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Option 2" required>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="questions[${questionCount}][correct_answer]" value="2" class="mr-2">
                        <input type="text" name="questions[${questionCount}][options][]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Option 3" required>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="questions[${questionCount}][correct_answer]" value="3" class="mr-2">
                        <input type="text" name="questions[${questionCount}][options][]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Option 4" required>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(questionDiv);
        questionCount++;
    }

    // Add first question automatically
    addQuestion();

    // Add question button click handler
    document.getElementById('add-question').addEventListener('click', addQuestion);
});
</script>
@endsection
@endsection
