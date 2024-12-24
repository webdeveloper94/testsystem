@extends('layouts.admin', ['title' => 'Edit Test'])

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Edit Test</h1>
        <a href="{{ route('admin.tests.index') }}" class="text-indigo-600 hover:text-indigo-900">
            <i class="fas fa-arrow-left mr-2"></i> Back to Tests
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('admin.tests.update', $test->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" value="{{ old('title', $test->title) }}" required>
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" required>{{ old('description', $test->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="time_limit" class="block text-gray-700 text-sm font-bold mb-2">Time Limit (minutes)</label>
                    <input type="number" name="time_limit" id="time_limit" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('time_limit') border-red-500 @enderror" value="{{ old('time_limit', $test->time_limit) }}" required min="1">
                    @error('time_limit')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="passing_score" class="block text-gray-700 text-sm font-bold mb-2">Passing Score (%)</label>
                    <input type="number" name="passing_score" id="passing_score" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('passing_score') border-red-500 @enderror" value="{{ old('passing_score', $test->passing_score) }}" required min="0" max="100">
                    @error('passing_score')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="questions_per_test" class="block text-gray-700 text-sm font-bold mb-2">Questions Per Test</label>
                <input type="number" name="questions_per_test" id="questions_per_test" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('questions_per_test') border-red-500 @enderror" value="{{ old('questions_per_test', $test->questions_per_test) }}" required>
                @error('questions_per_test')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" class="form-checkbox h-4 w-4 text-indigo-600" value="1" {{ old('is_active', $test->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                    Update Test
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
