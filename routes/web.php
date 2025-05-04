<?php

use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\NotificationCategoryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoleHasPermissionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserHasPermissionController;
use App\Http\Controllers\Admin\UserHasRoleController;
use App\Http\Controllers\API\ApiRoleHasPermissionController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Page\ContactController;
use App\Http\Controllers\Forum\ForumController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\Message\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Models\UserHasPermission;
use App\Http\Controllers\Notification\NotificationController as UserNotificationController;
use App\Http\Controllers\Page\IndexController as PageIndexController;

// forgot password
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/', [LoginController::class, 'login']);

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

Route::prefix('/register')->group(function(){
    Route::get('/', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/', [RegisterController::class, 'register']);
})->middleware('guest');

Route::get('/home', [IndexController::class, 'index'])->name('home.index')->middleware('auth');

//verify email -------------------
Route::prefix('/email')->name('verification.')->group(function(){
    Route::get('/verify', [RegisterController::class, 'notice'])->name('notice');
    Route::get('/verify/{token}', [RegisterController::class, 'verifyEmail'])->name('verify');
    Route::post('/resend', [RegisterController::class, 'resendVerificationEmail'])->name('resend');
});


Route::get('/change-password', [ChangePasswordController::class, 'show_form'])
        ->name('password.form');
    
    // Xử lý đổi mật khẩu
Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])
        ->name('password.change');

Route::prefix('/admin')->name('admin.')->group(function(){
    Route::get('/departments', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/departments/{id}', [DepartmentController::class, 'detail'])->name('department.detail');
    Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');

    Route::get('/teachers', [TeacherController::class, 'index'])->name('teacher.index');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teacher.create');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teacher.store');
    Route::get('/teachers/{id}', [TeacherController::class, 'show'])->name('teacher.show');
    Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teacher.edit');
    Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teacher.update');
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy');

    // Routes quản lý lớp học
    Route::get('/classes', [ClassController::class, 'index'])->name('class.index');
    Route::get('/classes/create', [ClassController::class, 'create'])->name('class.create');
    Route::post('/classes', [ClassController::class, 'store'])->name('class.store');
    Route::get('/classes/{id}', [ClassController::class, 'show'])->name('class.show');
    Route::get('/classes/{id}/edit', [ClassController::class, 'edit'])->name('class.edit');
    Route::put('/classes/{id}', [ClassController::class, 'update'])->name('class.update');
    Route::delete('/classes/{id}', [ClassController::class, 'destroy'])->name('class.destroy');

    // Routes quản lý sinh viên
    Route::get('/students', [StudentController::class, 'index'])->name('student.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/students', [StudentController::class, 'store'])->name('student.store');
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('student.show');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
});  // Department routes


    
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    //user
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/create', [UserController::class, 'store'])->name('user.create');
    Route::post('/user/create', [UserController::class, 'store'])->name('user.create');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/{id}', [UserController::class, 'detail'])->name('user.detail');
    Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');


    // Route để hiển thị form nhập Excel
    Route::get('/users/import-excel', [UserController::class, 'showImportForm'])->name('user.import-excel');

    // Route để xử lý file Excel được upload
    Route::post('/users/import-excel', [UserController::class, 'processImportExcel'])->name('user.process-import-excel');

    // Route để tải mẫu file Excel
    Route::get('/users/download-excel-template', [UserController::class, 'downloadExcelTemplate'])->name('user.download-excel-template');

    // Route::prefix('/role')
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role/create', [RoleController::class, 'store'])->name('role.create');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('admin/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

    Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permission/create', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/{id}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/destroy/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');

    Route::get('/user-has-role', [UserHasRoleController::class, 'index'])->name('user_has_role');
    Route::get('/user-has-role/create', [UserHasRoleController::class, 'create'])->name('user_has_role.create');
    Route::get('/user-has-role/{id}/create', [UserHasRoleController::class, 'create_with_user'])->name('user_has_role.create_with_user');
    Route::post('/user-has-role/create', [UserHasRoleController::class, 'store'])->name('user_has_role.create');

    Route::get('/user-has-permission/{id}/create', [UserHasPermissionController::class, 'create_with_user'])->name('user_has_permission.create_with_user');
    Route::post('/user-has-permission/create', [UserHasPermissionController::class, 'store'])->name('user_has_permission.create');

    Route::get('/role-has-permission', [RoleHasPermissionController::class, 'index'])->name('role_has_permission');
    Route::get('/role-has-permission/create', [RoleHasPermissionController::class, 'create'])->name('role_has_permission.create');
    Route::post('/role-has-permission/create', [RoleHasPermissionController::class, 'store'])->name('role_has_permission.create');
    
    //API ajax Role has permission
    Route::get('/api/role_has_permission/getByRoleId/{role_id?}', [ApiRoleHasPermissionController::class, 'getByRoleId'])->name('api.role_has_permission.getRoleId');

    Route::get('/notification-categories', [NotificationCategoryController::class, 'index'])->name('notification-category.index');
    Route::get('/notification-categories/create', [NotificationCategoryController::class, 'create'])->name('notification-category.create');
    Route::post('/notification-categories', [NotificationCategoryController::class, 'store'])->name('notification-category.store');
    Route::get('/notification-categories/{id}/edit', [NotificationCategoryController::class, 'edit'])->name('notification-category.edit');
    Route::put('/notification-categories/{id}', [NotificationCategoryController::class, 'update'])->name('notification-category.update');
    Route::delete('/notification-categories/{id}', [NotificationCategoryController::class, 'destroy'])->name('notification-category.destroy');

    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notification.create');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notification.store');
    Route::get('/notifications/{id}', [NotificationController::class, 'detail'])->name('notification.detail');
    Route::get('/notifications/{id}/edit', [NotificationController::class, 'edit'])->name('notification.edit');
    Route::put('/notifications/{id}', [NotificationController::class, 'update'])->name('notification.update');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notification.destroy');
});

//contact -----------------------------
Route::prefix('/contact')->name('contact.')->middleware('auth')->group(function(){
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::get('/student', [ContactController::class, 'student'])->name('student');
    Route::get('/teacher', [ContactController::class, 'teacher'])->name('teacher');
    Route::get('/teacher/search', [ContactController::class, 'search_teacher'])->name('teacher.search');

    Route::get('/department', [ContactController::class, 'department'])->name('department');
});


// -------------
Route::get('/message', [MessageController::class, 'index'])->name('message.index');
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
// Route::get('/notification', [UserNotificationController::class, 'index'])->name('notification.index');
Route::get('/notification', [PageIndexController::class, 'notification'])->name('notification.index');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
