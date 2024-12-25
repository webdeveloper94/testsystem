@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Test natijalari</h1>
        
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-6">
                @if($results->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test nomi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ball</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sarflangan vaqt</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sana</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Holat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Yechim</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($results as $result)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-clipboard-list text-blue-500 mr-3"></i>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $result->test->title }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ Str::limit($result->test->description, 50) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($result->score >= 70)
                                                <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                                            @endif
                                            <span class="text-sm {{ $result->score >= 70 ? 'text-green-600' : 'text-red-600' }} font-semibold">
                                                {{ number_format($result->score, 1) }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ floor($result->time_taken / 60) }}m {{ $result->time_taken % 60 }}s
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $result->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($result->score >= 70)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                O'tdi
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                O'tmadi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('tests.solution', ['test' => $result->test->id, 'result' => $result->id]) }}" 
                                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-eye mr-2"></i>
                                            Yechimni ko'rish
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        <div class="bg-blue-50 rounded-lg p-6">
                            <h4 class="text-blue-600 font-semibold mb-2">O'rtacha ball</h4>
                            <p class="text-3xl font-bold text-blue-800">
                                {{ number_format($results->avg('score'), 1) }}%
                            </p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-6">
                            <h4 class="text-green-600 font-semibold mb-2">O'tgan testlar</h4>
                            <p class="text-3xl font-bold text-green-800">
                                {{ $results->where('score', '>=', 70)->count() }}
                            </p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-6">
                            <h4 class="text-purple-600 font-semibold mb-2">Jami testlar</h4>
                            <p class="text-3xl font-bold text-purple-800">
                                {{ $results->count() }}
                            </p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-clipboard-list text-5xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Siz hali birorta test topshirmadingiz.</p>
                        <a href="{{ route('tests.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-300">
                            <i class="fas fa-clipboard-list mr-2"></i>
                            Testlarni ko'rish
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .grid > div {
        animation: slideIn 0.6s ease-out forwards;
    }
    
    .grid > div:nth-child(1) { animation-delay: 0.1s; }
    .grid > div:nth-child(2) { animation-delay: 0.2s; }
    .grid > div:nth-child(3) { animation-delay: 0.3s; }
    
    tr {
        animation: slideIn 0.4s ease-out forwards;
    }
</style>
@endpush
@endsection
