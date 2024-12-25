@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Xush kelibsiz, {{ Auth::user()->name }}!</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Available Tests Card -->
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-clipboard-list text-blue-500 text-xl"></i>
                            </div>
                            <h3 class="ml-4 text-lg font-semibold text-gray-700">Mavjud testlar</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Yangi testni boshlang yoki davom ettiring.</p>
                        <a href="{{ route('tests.index') }}" class="inline-flex items-center text-blue-500 hover:text-blue-600">
                            Testlarni ko'rish
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>

                    <!-- Test Results Card -->
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-chart-line text-green-500 text-xl"></i>
                            </div>
                            <h3 class="ml-4 text-lg font-semibold text-gray-700">Natijalaringiz</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Test tarixi va natijalarini ko'ring.</p>
                        <a href="{{ route('tests.results') }}" class="inline-flex items-center text-green-500 hover:text-green-600">
                            Natijalarni ko'rish
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>

                    <!-- Profile Card -->
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-purple-100 rounded-full">
                                <i class="fas fa-user text-purple-500 text-xl"></i>
                            </div>
                            <h3 class="ml-4 text-lg font-semibold text-gray-700">Profil</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Profilingizni sozlang va yangilang.</p>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center text-purple-500 hover:text-purple-600">
                            Profilni tahrirlash
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                @if($latestResults ?? null)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">So'nggi faoliyat</h3>
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test nomi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ball</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sana</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($latestResults as $result)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $result->test->title }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $result->score >= 70 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ number_format($result->score, 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $result->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
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
</style>
@endpush
@endsection
