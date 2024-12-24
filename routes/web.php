<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\Test;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/tests.index', [TestController::class, 'index'])->name('tests.index');


Route::get('/tests', [TestController::class, 'results'])->name('tests.results');


Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->is_admin == 1) {
        return redirect('/admin/dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function() {
        if (auth()->user()->is_admin != 1) {
            return redirect('/dashboard');
        }
        return app(DashboardController::class)->index();
    })->name('dashboard');
    
    // Tests routes
    Route::controller(TestController::class)->group(function () {
        Route::get('/tests', function() {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(TestController::class)->index();
        })->name('tests.index');
        
        Route::get('/tests/create', function() {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(TestController::class)->create();
        })->name('tests.create');
        
        Route::post('/tests', function() {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(TestController::class)->store(request());
        })->name('tests.store');
        
        Route::get('/tests/{test}/edit', function(Test $test) {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(TestController::class)->edit($test);
        })->name('tests.edit');
        
        Route::put('/tests/{test}', function(Test $test) {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(TestController::class)->update(request(), $test);
        })->name('tests.update');
        
        Route::delete('/tests/{test}', function(Test $test) {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(TestController::class)->destroy($test);
        })->name('tests.destroy');
    });
    
    // Users routes
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', function() {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(UserController::class)->index();
        })->name('users.index');
        
        Route::get('/users/create', function() {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(UserController::class)->create();
        })->name('users.create');
        
        Route::post('/users', function() {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(UserController::class)->store(request());
        })->name('users.store');
        
        Route::get('/users/{user}/edit', function(User $user) {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(UserController::class)->edit($user);
        })->name('users.edit');
        
        Route::put('/users/{user}', function(User $user) {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(UserController::class)->update(request(), $user);
        })->name('users.update');
        
        Route::delete('/users/{user}', function(User $user) {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(UserController::class)->destroy($user);
        })->name('users.destroy');
        
        Route::put('/users/{user}/toggle-block', function(User $user) {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(UserController::class)->toggleBlock($user);
        })->name('users.toggle-block');
    });
    
    // Results routes
    Route::controller(ResultController::class)->group(function () {
        Route::get('/results', function() {
            if (auth()->user()->is_admin != 1) return redirect('/dashboard');
            return app(ResultController::class)->index();
        })->name('results.index');
    });
});

require __DIR__.'/auth.php';
