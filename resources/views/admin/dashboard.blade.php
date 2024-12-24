@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Tests Card -->
    <div class="stats-card rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-75">Total Tests</p>
                <h3 class="text-3xl font-bold">{{ $totalTests }}</h3>
            </div>
            <div class="text-3xl opacity-75">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.tests.index') }}" class="text-sm hover:underline">View all tests →</a>
        </div>
    </div>

    <!-- Total Users Card -->
    <div class="stats-card rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-75">Total Users</p>
                <h3 class="text-3xl font-bold">{{ $totalUsers }}</h3>
            </div>
            <div class="text-3xl opacity-75">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.users.index') }}" class="text-sm hover:underline">Manage users →</a>
        </div>
    </div>

    <!-- Tests Taken Card -->
    <div class="stats-card rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-75">Tests Taken</p>
                <h3 class="text-3xl font-bold">{{ $totalTestsTaken }}</h3>
            </div>
            <div class="text-3xl opacity-75">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.results.index') }}" class="text-sm hover:underline">View results →</a>
        </div>
    </div>

    <!-- Active Users Card -->
    <div class="stats-card rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-75">Active Users</p>
                <h3 class="text-3xl font-bold">{{ $activeUsers }}</h3>
            </div>
            <div class="text-3xl opacity-75">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.users.index') }}" class="text-sm hover:underline">View active users →</a>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-xl font-bold mb-4">Recent Activity</h2>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($recentActivity as $activity)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $activity->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $activity->action }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $activity->test->title ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection