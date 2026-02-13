<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BrandController;


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

Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('users', [UserController::class, 'index'])->name('admin.users');
    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{id}/update', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{id}/destroy', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('admin/users/data', [UserController::class, 'getUsers'])->name('admin.users.data');


    Route::get('admin/brand', [BrandController::class, 'index'])->name('admin.brand');
    Route::get('admin/brand/create', [BrandController::class, 'create'])->name('admin.brand.create');
    Route::post('admin/brand/store', [BrandController::class, 'store'])->name('admin.brand.store');
    Route::get('admin/brand/edit/{brand}', [BrandController::class, 'edit'])->name('admin.brand.edit');
    Route::put('admin/brand/update/{brand}', [BrandController::class, 'update'])->name('admin.brand.update');
    Route::delete('admin/brand/destroy/{brand}', [BrandController::class, 'destroy'])->name('admin.brand.destroy');
});

Route::middleware(['auth', 'role:1,2'])->prefix('admin')->group(function () {

    Route::get('chat', [AdminController::class, 'chat'])->name('admin.chat');
    Route::get('chat/{chatId}', [AdminController::class, 'show'])->name('admin.chat.show');
    Route::get('chat/{chatId}/messages', [AdminController::class, 'messages'])->name('admin.chat.messages');

    Route::post('send-message', [MessageController::class, 'send'])->name('admin.chat.send');
    Route::post('chat/start', [MessageController::class, 'chartStart'])->name('admin.chat.start');
    Route::post('chat/typing', [MessageController::class, 'typing'])->name('admin.chat.typing');
    Route::post('chat/mark-read', [MessageController::class, 'markRead'])->name('admin.chat.markRead');
    Route::post('chat/close', [MessageController::class, 'closeChat'])->name('admin.chat.close');

    // Notifications
    Route::get('notification', [AdminController::class, 'notification'])->name('admin.notification');
    Route::get('notification/data', [AdminController::class, 'getNotification'])->name('admin.notification.data');
    Route::post('notifications/mark-as-read', [AdminController::class, 'markAsRead'])->name('admin.notifications.markAsRead');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/profile', [ProfileController::class, 'profile'])->name('admin.profile.index');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
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
