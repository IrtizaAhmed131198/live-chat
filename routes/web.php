<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Events\TestMessage;


Route::get('/', function () {
    return view('welcome');
});

// Login/Register Routes (sirf guests ke liye - logged in users redirect hoge dashboard par)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/signin', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/signup', [RegisterController::class, 'register'])->name('register.post');
});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes (sirf authenticated users ke liye)
Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/chat', [AdminController::class, 'chat'])->name('admin.chat');
    Route::post('admin/send-message', [MessageController::class, 'send']);
});

Route::get('/memory-test', function () {
    echo ini_get('memory_limit');
});

// Redirect logged-in users away from auth pages
Route::middleware('auth')->group(function () {
    Route::redirect('/login', 'admin/dashboard');
    Route::redirect('/register', 'admin/dashboard');
});

Route::get('/test-socket', function () {
    broadcast(new TestMessage());
});
