<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LogsUpdateController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Page\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// LOGIN/REGISTER/LOGOUT PAGE
Route::get('/', [AuthController::class ,'loginView'])->name('login.view')->middleware(['guest']);
Route::get('/register', [AuthController::class ,'registerView'])->name('register.view')->middleware(['guest']);
Route::get('/reset-password', [ResetPasswordController::class ,'viewResetPassword'])->name('reset.password.view')->middleware(['guest']);
Route::get('/reset-password/{token}', [ResetPasswordController::class ,'tokenResetPasswordView'])->name('password.reset')->middleware(['guest']);

// VERIFY EMAIL
Route::get('/email/verify', [AuthController::class,'verifyEmail'])->name('verification.notice')->middleware(['web','auth:sanctum']);
Route::post('/email/resend', [AuthController::class,'resendVerifyEmail'])->name('verification.resend')->middleware(['web','auth:sanctum','throttle:1,1']);
Route::get('/email/verify/{id}/{hash}',[AuthController::class,'handleVerifyEmail'])->middleware(['web','auth:sanctum', 'signed'])->name('verification.verify');


// AUTH PAGE
Route::middleware(['web','auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [PageController::class ,'dashboard'])->name('dashboard.view');
    Route::get('/docs', [PageController::class ,'docs'])->name('docs.view');
    Route::get('/logs', [PageController::class ,'logs'])->name('logs.view');
    Route::get('/profile', [PageController::class ,'profile'])->name('profile.view');
    Route::get('/saldo', [PageController::class ,'saldo'])->name('saldo.view');
    Route::get('/books', [PageController::class ,'books'])->name('books.view');
});

// ADMIN PAGE
Route::middleware(['web','auth:sanctum', 'isDewa'])->group(function () {
    Route::resource('/admin', AdminController::class);
    Route::resource('/logs-add', LogsUpdateController::class);
});



