<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Forum\ForumController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Notification\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

//verify email -------------------
Route::prefix('/email')->name('verification.')->group(function(){
    Route::get('/verify', [RegisterController::class, 'notice'])->name('notice');
    Route::get('/verify/{token}', [RegisterController::class, 'verifyEmail'])->name('verify');
    Route::post('/resend', [RegisterController::class, 'resendVerificationEmail'])->name('resend');
});


Route::get('/home', [IndexController::class, 'index'])->name('home.index');

//contact -----------------------------
Route::prefix('/contact')->name('contact.')->group(function(){
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::get('/student', [ContactController::class, 'student'])->name('student');
    Route::get('/teacher', [ContactController::class, 'teacher'])->name('teacher');
    Route::get('/department', [ContactController::class, 'department'])->name('department');
});

Route::get('/message', [MessageController::class, 'index'])->name('message.index');
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');


Route::get('/admin', [DashboardController::class, 'index']);
