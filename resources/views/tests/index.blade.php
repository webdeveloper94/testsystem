@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Available Tests</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tests as $test)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-500 hover:scale-105">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-clipboard-list text-2xl text-blue-500 mr-3"></i>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $test->title }}</h2>
                    </div>
                    
                    <p class="text-gray-600 mb-4">{{ $test->description }}</p>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <div class="flex items-center mr-4">
                            <i class="far fa-clock mr-2"></i>
                            <span>{{ $test->time_limit }} minutes</span>
                        </div>
                        <div class="flex items-center">
                            <i class="far fa-question-circle mr-2"></i>
                            <span>{{ $test->questions_per_test }} questions</span>
                        </div>
                    </div>

                    @php
                        $latestResult = $test->results()->where('user_id', auth()->id())->latest()->first();
                    @endphp

                    @if($latestResult)
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm">
                            <i class="fas fa-trophy {{ $latestResult->score >= 70 ? 'text-yellow-500' : 'text-gray-400' }} mr-2"></i>
                            Last attempt: {{ number_format($latestResult->score, 1) }}%
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $latestResult->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @endif
                    
                    <div class="flex justify-between items-center mt-4">
                        <a href="{{ route('tests.show', $test) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-300">
                            <i class="fas fa-play-circle mr-2"></i>
                            Start Test
                        </a>
                        
                        <a href="{{ route('tests.results') }}?test_id={{ $test->id }}" 
                           class="text-blue-500 hover:text-blue-600 text-sm">
                            <i class="fas fa-history mr-1"></i>
                            View History
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($tests->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-clipboard-list text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">No tests available at the moment.</p>
        </div>
        @endif
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .grid > div {
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }
    
    .grid > div:nth-child(1) { animation-delay: 0.1s; }
    .grid > div:nth-child(2) { animation-delay: 0.2s; }
    .grid > div:nth-child(3) { animation-delay: 0.3s; }
    .grid > div:nth-child(4) { animation-delay: 0.4s; }
    .grid > div:nth-child(5) { animation-delay: 0.5s; }
    .grid > div:nth-child(6) { animation-delay: 0.6s; }
</style>
@endpush
@endsection
