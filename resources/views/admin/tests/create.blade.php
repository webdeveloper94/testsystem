@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Create New Test</h1>
        <a href="{{ route('admin.tests.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors duration-200">
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
                <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="time_limit" class="block text-gray-700 text-sm font-bold mb-2">Time Limit (minutes)</label>
                <input type="number" name="time_limit" id="time_limit" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('time_limit') border-red-500 @enderror" value="{{ old('time_limit', 30) }}" required>
                @error('time_limit')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
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

            <div class="mb-4">
                <h3 class="text-lg font-semibold mb-2">Questions</h3>
                <div id="questions-container">
                    <!-- Questions will be added here dynamically -->
                </div>
                <button type="button" id="add-question" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Add Question
                </button>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i> Save Test
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let questionCount = 0;
    const questionsContainer = document.getElementById('questions-container');
    const addQuestionButton = document.getElementById('add-question');

    function createQuestionHTML(index) {
        return `
            <div class="question-item bg-gray-50 p-4 rounded-lg mb-4">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="text-lg font-medium">Question #${index + 1}</h4>
                    <button type="button" class="remove-question text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Question Text</label>
                    <textarea name="questions[${index}][text]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="2" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Question Image</label>
                    <input type="file" name="questions[${index}][image]" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <p class="text-sm text-gray-500 mt-1">Optional. Supported formats: JPG, PNG, GIF</p>
                </div>
                <div class="answers-container">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                <input type="radio" name="questions[${index}][correct_answer]" value="0" required>
                                <span class="ml-2">Option A</span>
                            </label>
                            <input type="text" name="questions[${index}][answers][]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                <input type="radio" name="questions[${index}][correct_answer]" value="1" required>
                                <span class="ml-2">Option B</span>
                            </label>
                            <input type="text" name="questions[${index}][answers][]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                <input type="radio" name="questions[${index}][correct_answer]" value="2" required>
                                <span class="ml-2">Option C</span>
                            </label>
                            <input type="text" name="questions[${index}][answers][]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                <input type="radio" name="questions[${index}][correct_answer]" value="3" required>
                                <span class="ml-2">Option D</span>
                            </label>
                            <input type="text" name="questions[${index}][answers][]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function addQuestion() {
        const questionHTML = createQuestionHTML(questionCount);
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = questionHTML;
        const questionElement = tempDiv.firstElementChild;
        
        // Add remove functionality
        const removeButton = questionElement.querySelector('.remove-question');
        removeButton.addEventListener('click', function() {
            this.closest('.question-item').remove();
            updateQuestionNumbers();
        });

        questionsContainer.appendChild(questionElement);
        questionCount++;
    }

    function updateQuestionNumbers() {
        const questions = questionsContainer.querySelectorAll('.question-item');
        questions.forEach((question, index) => {
            // Update question number in heading
            question.querySelector('h4').textContent = `Question #${index + 1}`;
            
            // Update name attributes
            const textarea = question.querySelector('textarea');
            textarea.name = `questions[${index}][text]`;

            const imageInput = question.querySelector('input[type="file"]');
            imageInput.name = `questions[${index}][image]`;

            const radioButtons = question.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radio => {
                radio.name = `questions[${index}][correct_answer]`;
            });

            const answerInputs = question.querySelectorAll('input[type="text"]');
            answerInputs.forEach((input, answerIndex) => {
                input.name = `questions[${index}][answers][]`;
            });
        });
        questionCount = questions.length;
    }

    // Add question button click handler
    addQuestionButton.addEventListener('click', addQuestion);

    // Add first question automatically
    addQuestion();
});
</script>
@endpush
@endsection