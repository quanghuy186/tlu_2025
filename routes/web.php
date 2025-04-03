<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Forum\ForumController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Notification\NotificationController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::get('/home', [IndexController::class, 'index'])->name('home.index');


Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::get('/contact/student', [ContactController::class, 'student'])->name('contact.student');
Route::get('/contact/teacher', [ContactController::class, 'teacher'])->name('contact.teacher');
Route::get('/contact/department', [ContactController::class, 'department'])->name('contact.department');


Route::get('/message', [MessageController::class, 'index'])->name('message.index');
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
