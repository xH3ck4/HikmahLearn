<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Page\PageController;
use App\Http\Controllers\Payment\CallbackController;
use App\Http\Controllers\Payment\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// SERVICES
use App\Http\Controllers\API\AlquranAyatController;
use App\Http\Controllers\API\AlquranSurahController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Auth
Route::post('/login', [AuthController::class ,'loginPost'])->name('login.post');
Route::post('/register', [AuthController::class ,'registerPost'])->name('register.post');
Route::post('/logout', [AuthController::class ,'logout'])->name('logout')->name('logout')->middleware(['web','auth:sanctum']);

// API Send Reset Password
Route::post('/reset-password', [ResetPasswordController::class ,'sendResetLink'])->name('reset.password')->middleware(['throttle:1,1']);
Route::post('/new-password', [ResetPasswordController::class ,'newPassword'])->name('new.password');

// API Profile
Route::get('/getprofile', [PageController::class ,'profile_api'])->name('profile.api')->middleware(['web','auth:sanctum']);
Route::post('/updateprofile', [PageController::class ,'update_profile_api'])->name('update.profile.api')->middleware(['web','auth:sanctum']);
Route::post('/profile/ganti-password', [ResetPasswordController::class ,'updateProfilePassword'])->name('update.profile.password')->middleware(['web','auth:sanctum']);

// TOP UP SALDO PAYMENT
Route::post('/topup', [PaymentController::class ,'TopupSaldo'])->name('TopupSaldo')->middleware(['web','auth:sanctum']);
Route::post('/topup/batal', [PaymentController::class ,'TopupSaldoBatal'])->name('TopupSaldo.batal')->middleware(['web','auth:sanctum']);


// CALLBACK MIDTRANS PAYMENT
Route::post('/callback/midtrans',[CallbackController::class,'callbackPay'])->name('callback.payment');


// SERVICES API

Route::middleware(['ApiServices'])->group(function () {

    // API ALQURAN
    Route::get('alquran/surah', [AlquranSurahController::class, 'index'])->name('alquransurah.index');

    Route::get('alquran/ayat', [AlquranAyatController::class, 'index'])->name('alquranayat.index');

});


