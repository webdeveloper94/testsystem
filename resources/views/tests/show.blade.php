@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-800 overflow-hidden shadow-lg rounded-lg">
            <!-- Test Header -->
            <div class="p-6 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                <h1 class="text-2xl font-bold mb-2">{{ $test->title }}</h1>
                <div class="flex items-center text-sm">
                    <div class="mr-4">
                        <i class="far fa-clock mr-1"></i>
                        Time Remaining: <span id="timer" class="font-semibold">{{ $test->time_limit }}:00</span>
                    </div>
                    <div>
                        <i class="far fa-question-circle mr-1"></i>
                        Questions: <span id="questionCounter" class="font-semibold">1</span>/{{ count($questions) }}
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="relative h-2 bg-gray-700">
                <div id="progressBar" class="absolute h-2 bg-blue-500 transition-all duration-300" style="width: 0%"></div>
            </div>

            <!-- Question Area -->
            <div id="questionContainer" class="p-6">
                @foreach($questions as $index => $question)
                <div class="question-slide {{ $index === 0 ? '' : 'hidden' }}" data-question-id="{{ $question->id }}">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-4">
                            {{ $question->question_text }}
                        </h3>

                        @php
                            $questionImage = App\Models\QuestionImage::where('test_id', $test->id)
                                ->where('question_index', $index)
                                ->first();
                        @endphp

                        @if($questionImage)
                            <div class="mb-4">
                                <img src="{{ Storage::url($questionImage->image_path) }}" alt="Question Image" class="max-w-full h-auto rounded-lg">
                            </div>
                        @endif
                        
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-gray-700 rounded-lg cursor-pointer transition-all duration-300 hover:bg-gray-700 option-label">
                                <input type="radio" name="question_{{ $question->id }}" value="a" class="hidden">
                                <div class="w-6 h-6 border-2 border-blue-500 rounded-full mr-3 flex items-center justify-center option-radio">
                                    <div class="w-3 h-3 rounded-full bg-blue-500 opacity-0 transition-opacity duration-300"></div>
                                </div>
                                <span class="text-gray-300">{{ $question->option_a }}</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-700 rounded-lg cursor-pointer transition-all duration-300 hover:bg-gray-700 option-label">
                                <input type="radio" name="question_{{ $question->id }}" value="b" class="hidden">
                                <div class="w-6 h-6 border-2 border-blue-500 rounded-full mr-3 flex items-center justify-center option-radio">
                                    <div class="w-3 h-3 rounded-full bg-blue-500 opacity-0 transition-opacity duration-300"></div>
                                </div>
                                <span class="text-gray-300">{{ $question->option_b }}</span>
                            </label>

                            @if($question->option_c)
                            <label class="flex items-center p-4 border border-gray-700 rounded-lg cursor-pointer transition-all duration-300 hover:bg-gray-700 option-label">
                                <input type="radio" name="question_{{ $question->id }}" value="c" class="hidden">
                                <div class="w-6 h-6 border-2 border-blue-500 rounded-full mr-3 flex items-center justify-center option-radio">
                                    <div class="w-3 h-3 rounded-full bg-blue-500 opacity-0 transition-opacity duration-300"></div>
                                </div>
                                <span class="text-gray-300">{{ $question->option_c }}</span>
                            </label>
                            @endif

                            @if($question->option_d)
                            <label class="flex items-center p-4 border border-gray-700 rounded-lg cursor-pointer transition-all duration-300 hover:bg-gray-700 option-label">
                                <input type="radio" name="question_{{ $question->id }}" value="d" class="hidden">
                                <div class="w-6 h-6 border-2 border-blue-500 rounded-full mr-3 flex items-center justify-center option-radio">
                                    <div class="w-3 h-3 rounded-full bg-blue-500 opacity-0 transition-opacity duration-300"></div>
                                </div>
                                <span class="text-gray-300">{{ $question->option_d }}</span>
                            </label>
                            @endif
                        </div>
                    </div>

                    <!-- Feedback Area (Initially Hidden) -->
                    <div class="feedback-area hidden mb-6">
                        <div class="p-4 rounded-lg mb-4 bg-gray-700">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-check-circle text-green-500 text-xl mr-2 correct-icon hidden"></i>
                                <i class="fas fa-times-circle text-red-500 text-xl mr-2 incorrect-icon hidden"></i>
                                <span class="feedback-text font-semibold text-white"></span>
                            </div>
                            @if($question->explanation)
                            <p class="text-gray-300 text-sm mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ $question->explanation }}
                            </p>
                            @endif
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center mt-6">
                        <button type="button" class="prev-btn {{ $index === 0 ? 'invisible' : '' }} px-4 py-2 text-blue-400 hover:text-blue-300 flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Previous
                        </button>
                        
                        <button type="button" class="check-answer-btn px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 flex items-center">
                            <i class="fas fa-check mr-2"></i>
                            Check Answer
                        </button>
                        
                        <button type="button" class="next-btn hidden px-4 py-2 text-blue-400 hover:text-blue-300 flex items-center">
                            Next
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                        
                        @if($index === count($questions) - 1)
                        <button type="button" class="submit-test-btn hidden px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 flex items-center">
                            <i class="fas fa-flag-checkered mr-2"></i>
                            Submit Test
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Result Modal -->
<div id="resultModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-gray-800 rounded-lg p-8 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="mb-4">
                <i id="resultIcon" class="text-6xl mb-4"></i>
            </div>
            <h2 class="text-2xl font-bold text-white mb-4">Test Complete!</h2>
            <div class="space-y-2 mb-6">
                <p class="text-gray-300">Score: <span id="finalScore" class="font-bold text-white"></span></p>
                <p class="text-gray-300">Correct Answers: <span id="correctAnswers" class="font-bold text-white"></span></p>
                <p class="text-gray-300">Time Taken: <span id="timeTaken" class="font-bold text-white"></span></p>
            </div>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('tests.index') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-list mr-2"></i>
                    All Tests
                </a>
                <a href="{{ route('tests.results') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                    <i class="fas fa-chart-bar mr-2"></i>
                    View Results
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .option-label.selected {
        border-color: #3b82f6;
        background-color: rgba(59, 130, 246, 0.1);
    }

    .option-label.selected .option-radio {
        border-color: #3b82f6;
    }

    .option-label.selected .option-radio div {
        opacity: 1;
    }

    .option-label.correct {
        border-color: #10b981;
        background-color: rgba(16, 185, 129, 0.1);
    }

    .option-label.incorrect {
        border-color: #ef4444;
        background-color: rgba(239, 68, 68, 0.1);
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .question-slide {
        animation: slideIn 0.5s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentQuestionIndex = 0;
    const questions = document.querySelectorAll('.question-slide');
    const totalQuestions = questions.length;
    let answers = {};
    let startTime = new Date();

    // Add event listeners for radio buttons
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const questionId = this.closest('.question-slide').dataset.questionId;
            answers[questionId] = this.value;
            console.log('Answer selected:', { questionId, value: this.value });
            console.log('Current answers:', answers);
            
            // Update the selected state of the parent label
            const labels = this.closest('.question-slide').querySelectorAll('.option-label');
            labels.forEach(label => label.classList.remove('selected'));
            this.closest('.option-label').classList.add('selected');
        });
    });

    // Timer function
    let timeLimit = parseInt('{{ $test->time_limit }}') * 60;
    const timer = setInterval(() => {
        timeLimit--;
        const minutes = Math.floor(timeLimit / 60);
        const seconds = timeLimit % 60;
        document.getElementById('timer').textContent = 
            `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        if (timeLimit <= 0) {
            clearInterval(timer);
            submitTest();
        }
    }, 1000);

    // Function to show a specific question
    function showQuestion(index) {
        questions.forEach((q, i) => {
            if (i === index) {
                q.classList.remove('hidden');
            } else {
                q.classList.add('hidden');
            }
        });
        
        currentQuestionIndex = index;
        document.getElementById('questionCounter').textContent = index + 1;
        document.getElementById('progressBar').style.width = 
            `${((index + 1) / totalQuestions) * 100}%`;
    }

    // Check Answer button click handler
    document.querySelectorAll('.check-answer-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const currentSlide = questions[currentQuestionIndex];
            const questionId = currentSlide.dataset.questionId;
            const selectedOption = currentSlide.querySelector('input[type="radio"]:checked');
            
            if (!selectedOption) {
                alert('Please select an answer before checking.');
                return;
            }
            
            try {
                const response = await fetch('{{ route("tests.check-answer") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        question_id: questionId,
                        selected_option: selectedOption.value
                    })
                });
                
                const result = await response.json();
                
                // Show feedback
                const feedbackArea = currentSlide.querySelector('.feedback-area');
                const correctIcon = feedbackArea.querySelector('.correct-icon');
                const incorrectIcon = feedbackArea.querySelector('.incorrect-icon');
                const feedbackText = feedbackArea.querySelector('.feedback-text');
                
                feedbackArea.classList.remove('hidden');
                if (result.correct) {
                    correctIcon.classList.remove('hidden');
                    incorrectIcon.classList.add('hidden');
                    feedbackText.textContent = 'Correct!';
                    selectedOption.closest('.option-label').classList.add('correct');
                } else {
                    correctIcon.classList.add('hidden');
                    incorrectIcon.classList.remove('hidden');
                    feedbackText.textContent = 'Incorrect. The correct answer is: ' + 
                        result.correctOption.toUpperCase();
                    selectedOption.closest('.option-label').classList.add('incorrect');
                }
                
                // Hide check answer button and show next/submit button
                this.classList.add('hidden');
                if (currentQuestionIndex === totalQuestions - 1) {
                    currentSlide.querySelector('.submit-test-btn').classList.remove('hidden');
                } else {
                    currentSlide.querySelector('.next-btn').classList.remove('hidden');
                }
                
            } catch (error) {
                console.error('Error checking answer:', error);
                alert('An error occurred while checking the answer. Please try again.');
            }
        });
    });

    // Next button click handler
    document.querySelectorAll('.next-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentQuestionIndex < totalQuestions - 1) {
                showQuestion(currentQuestionIndex + 1);
            }
        });
    });

    // Previous button click handler
    document.querySelectorAll('.prev-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentQuestionIndex > 0) {
                showQuestion(currentQuestionIndex - 1);
            }
        });
    });

    // Submit test
    async function submitTest() {
        const timeTaken = Math.floor((new Date() - startTime) / 1000);
        
        try {
            // Validate answers
            if (Object.keys(answers).length === 0) {
                alert('Please answer at least one question before submitting.');
                return;
            }
            
            console.log('Submitting test with answers:', answers);
            console.log('Time taken:', timeTaken);
            
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                throw new Error('CSRF token not found');
            }
            
            const response = await fetch(`{{ route('tests.submit', $test) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token.getAttribute('content')
                },
                body: JSON.stringify({
                    answers: answers,
                    time_taken: timeTaken
                })
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Response not ok:', response.status, errorText);
                throw new Error(`Network response was not ok: ${response.status}`);
            }

            const result = await response.json();
            console.log('Test submission result:', result);
            
            if (result.error) {
                throw new Error(result.error);
            }
            
            // Show result modal
            const modal = document.getElementById('resultModal');
            const scoreElement = document.getElementById('finalScore');
            const correctAnswersElement = document.getElementById('correctAnswers');
            const timeTakenElement = document.getElementById('timeTaken');
            const resultIcon = document.getElementById('resultIcon');
            
            if (!modal || !scoreElement || !correctAnswersElement || !timeTakenElement || !resultIcon) {
                throw new Error('Required modal elements not found');
            }
            
            scoreElement.textContent = `${result.score.toFixed(1)}%`;
            correctAnswersElement.textContent = `${result.correctAnswers}/${result.totalQuestions}`;
            
            const minutes = Math.floor(result.timeTaken / 60);
            const seconds = result.timeTaken % 60;
            timeTakenElement.textContent = `${minutes}m ${seconds}s`;
            
            if (result.score >= 70) {
                resultIcon.className = 'fas fa-trophy text-yellow-500';
            } else {
                resultIcon.className = 'fas fa-star text-blue-500';
            }
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Clear timer
            clearInterval(timer);
        } catch (error) {
            console.error('Error submitting test:', error);
            alert('An error occurred while submitting the test. Please try again.');
        }
    }

    document.querySelectorAll('.submit-test-btn').forEach(btn => {
        btn.addEventListener('click', submitTest);
    });
});
</script>
@endpush
@endsection
