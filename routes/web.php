<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MessageController;
use App\Events\TestMessage;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/signin', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/signup', [RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/chat', [AdminController::class, 'chat'])->name('admin.chat');
    Route::post('admin/send-message', [MessageController::class, 'send'])->name('admin.chat.send');
    Route::get('admin/chat/{chatId}', [AdminController::class, 'show'])->name('admin.chat.show');

    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{id}/update', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{id}/destroy', [UserController::class, 'destroy'])->name('admin.users.destroy');
});


// Route::get('/memory-test', function () {
//     echo ini_get('memory_limit');
// });


Route::middleware('auth')->group(function () {
    Route::redirect('/login', 'admin/dashboard');
    Route::redirect('/register', 'admin/dashboard');
});

Route::get('/test-socket', function () {
    broadcast(new TestMessage());
});

Route::get('/widget.js', function () {
    return response()->file(public_path('widget/widget.js'), [
        'Content-Type' => 'application/javascript'
    ]);
});
