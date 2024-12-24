<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\User;
use App\Models\TestResult;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin != 1) {
            return redirect('/dashboard');
        }

        $totalTests = Test::count();
        $totalUsers = User::count();
        $totalTestsTaken = TestResult::count();
        $activeUsers = User::where('is_active', true)->count();
        $recentActivity = TestResult::with(['user', 'test'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalTests',
            'totalUsers',
            'totalTestsTaken',
            'activeUsers',
            'recentActivity'
        ));
    }
}
