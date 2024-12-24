<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\TestController as AdminTestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin == 1) {
            return app(DashboardController::class)->index();
        }
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Test routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/tests', [TestController::class, 'index'])->name('tests.index');
        Route::get('/tests/{test}', [TestController::class, 'show'])->name('tests.show');
        Route::post('/tests/{test}/submit', [TestController::class, 'submit'])->name('tests.submit');
        Route::get('/tests/{test}/results/{result}/solution', [TestController::class, 'showSolution'])->name('tests.solution');
    });
    Route::post('/tests/check-answer', [TestController::class, 'checkAnswer'])->name('tests.check-answer');
    Route::get('/test-results', [TestController::class, 'results'])->name('tests.results');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function() {
            if (!auth()->user()->is_admin) {
                return redirect('/dashboard');
            }
            return app(DashboardController::class)->index();
        })->name('dashboard');

        // Admin Test routes
        Route::get('/tests', [AdminTestController::class, 'index'])->name('tests.index');
        Route::get('/tests/create', [AdminTestController::class, 'create'])->name('tests.create');
        Route::post('/tests', [AdminTestController::class, 'store'])->name('tests.store');
        Route::get('/tests/{test}/edit', [AdminTestController::class, 'edit'])->name('tests.edit');
        Route::put('/tests/{test}', [AdminTestController::class, 'update'])->name('tests.update');
        Route::delete('/tests/{test}', [AdminTestController::class, 'destroy'])->name('tests.destroy');

        // Admin User routes
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('users.toggle-block');

        // Admin Results routes
        Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    });
});

require __DIR__.'/auth.php';
