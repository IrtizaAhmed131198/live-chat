<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Events\TestMessage;


Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/signin', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/signup', [RegisterController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/chat', [AdminController::class, 'chat'])->name('admin.chat');
    Route::get('admin/chat/{chatId}/messages', [AdminController::class, 'messages'])->name('admin.chat.messages');
    Route::get('admin/notification', [AdminController::class, 'notification'])->name('admin.notification');
    Route::post('admin/send-message', [MessageController::class, 'send'])->name('admin.chat.send');
    Route::post('admin/chat/start', [MessageController::class, 'chartStart'])->name('admin.chat.start');
    Route::post('admin/chat/typing', [MessageController::class, 'typing'])->name('admin.chat.typing');
    Route::post('/admin/chat/mark-read', [MessageController::class, 'markRead'])->name('admin.chat.markRead');
    Route::get('admin/chat/{chatId}', [AdminController::class, 'show'])->name('admin.chat.show');
    Route::get('/admin/profile', [ProfileController::class, 'profile'])->name('admin.profile.index');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

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


// Route::middleware('auth')->group(function () {
//     Route::redirect('/login', 'admin/dashboard');
//     Route::redirect('/register', 'admin/dashboard');
// });

Route::get('/test-socket', function () {
    broadcast(new TestMessage());
});

Route::get('/widget.js', function () {
    return response()->file(public_path('widget/widget.js'), [
        'Content-Type' => 'application/javascript'
    ]);
});

Route::post('/notifications/mark-read', function () {
    $user = auth()->user();
    $user->unreadNotifications->markAsRead();

    return response()->json(['status' => 'success']);
})->name('notifications.markRead');
