<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleHasPermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserHasRoleController;
use App\Http\Controllers\API\ApiRoleHasPermissionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Forum\ForumController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Notification\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

Route::get('/', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/', [LoginController::class, 'login'])
    ->middleware('guest');

Route::prefix('/register')->group(function(){
    Route::get('/', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/', [RegisterController::class, 'register']);
});

Route::get('/home', [IndexController::class, 'index'])->name('home.index')->middleware('auth');

//verify email -------------------
Route::prefix('/email')->name('verification.')->group(function(){
    Route::get('/verify', [RegisterController::class, 'notice'])->name('notice');
    Route::get('/verify/{token}', [RegisterController::class, 'verifyEmail'])->name('verify');
    Route::post('/resend', [RegisterController::class, 'resendVerificationEmail'])->name('resend');
});

// forgot password
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user-has-role', [UserHasRoleController::class, 'index'])->name('user_has_role');
    Route::get('/user-has-role/create', [UserHasRoleController::class, 'create'])->name('user_has_role.create');
    Route::get('/user-has-role/{id}/create', [UserHasRoleController::class, 'create_with_user'])->name('user_has_role.create_with_user');
    Route::post('/user-has-role/create', [UserHasRoleController::class, 'store'])->name('user_has_role.create');
    Route::get('/role-has-permission', [RoleHasPermissionController::class, 'index'])->name('role_has_permission');
    Route::get('/role-has-permission/create', [RoleHasPermissionController::class, 'create'])->name('role_has_permission.create');
    Route::post('/role-has-permission/create', [RoleHasPermissionController::class, 'store'])->name('role_has_permission.create');

    //API ajax Role has permission
    Route::get('/api/role_has_permission/getByRoleId/{role_id?}', [ApiRoleHasPermissionController::class, 'getByRoleId'])->name('api.role_has_permission.getRoleId');
});


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
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
