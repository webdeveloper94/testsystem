@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-4 text-gray-100">{{ $test->title }} - Test Results</h1>
            <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="grid grid-cols-2 gap-4 text-gray-300">
                    <div>
                        <p class="font-semibold">Score:</p>
                        <p class="text-2xl">{{ round($result->score, 2) }}%</p>
                    </div>
                    <div>
                        <p class="font-semibold">Time Taken:</p>
                        <p class="text-2xl">{{ floor($result->time_taken / 60) }}:{{ str_pad($result->time_taken % 60, 2, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Correct Answers:</p>
                        <p class="text-2xl">{{ $result->correct_answers }} / {{ $result->total_questions }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Status:</p>
                        <p class="text-2xl {{ $result->score >= $test->passing_score ? 'text-green-500' : 'text-red-500' }}">
                            {{ $result->score >= $test->passing_score ? 'PASSED' : 'FAILED' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            @foreach($questions as $index => $question)
            <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
                <h3 class="text-xl font-semibold mb-4 text-gray-100">
                    {{ $index + 1 }}. {{ $question->question_text }}
                </h3>

                @if($question->getImage())
                    <div class="mb-4">
                        <img src="{{ Storage::url($question->getImage()->image_path) }}" 
                             alt="Question Image" 
                             class="max-h-48 object-contain"
                        >
                    </div>
                @endif

                <div class="space-y-3">
                    @php
                        $options = [
                            'a' => $question->option_a,
                            'b' => $question->option_b,
                            'c' => $question->option_c,
                            'd' => $question->option_d
                        ];
                        $userAnswer = $userAnswers[$question->id] ?? null;
                    @endphp

                    @foreach($options as $key => $option)
                        @if($option)
                            <div class="p-4 border rounded-lg 
                                {{ $key === $question->correct_option ? 'border-green-500 bg-green-900 bg-opacity-20' : '' }}
                                {{ $key === $userAnswer && $key !== $question->correct_option ? 'border-red-500 bg-red-900 bg-opacity-20' : '' }}
                            ">
                                <div class="flex items-center">
                                    <span class="w-8 h-8 flex items-center justify-center rounded-full 
                                        {{ $key === $question->correct_option ? 'bg-green-500' : '' }}
                                        {{ $key === $userAnswer && $key !== $question->correct_option ? 'bg-red-500' : 'bg-gray-700' }}
                                    ">
                                        {{ strtoupper($key) }}
                                    </span>
                                    <span class="ml-3 text-gray-300">{{ $option }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                @if($question->explanation)
                    <div class="mt-4 p-4 bg-gray-700 rounded-lg">
                        <h4 class="font-semibold text-gray-100">Explanation:</h4>
                        <p class="text-gray-300">{{ $question->explanation }}</p>
                    </div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('tests.index') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                Back to Tests
            </a>
        </div>
    </div>
</div>
@endsection
