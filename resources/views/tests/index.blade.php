@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                    {{ __('Tests') }}
                </h2>

                @if($tests->isEmpty())
                    <p>No tests available.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($tests as $test)
                            <div class="border rounded-lg p-4 hover:shadow-lg transition-shadow">
                                <h3 class="text-lg font-semibold mb-2">{{ $test->title }}</h3>
                                <p class="text-gray-600 mb-4">{{ $test->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Time limit: {{ $test->time_limit }} minutes</span>
                                    <a href="{{ route('tests.show', $test) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Testni boshlash
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
