<?php

use App\Http\Controllers\Admin\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', fn() => "Welcome");
Route::group(['prefix' => 'auth'], function () {
  Route::post('/login', [Auth\LoginController::class, 'login'])->name('login');

  Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [Auth\LogoutController::class, 'logout'])->name('logout');
    Route::post('/refresh', [Auth\RefreshTokenController::class, 'refresh'])->name('refresh');
  });

  Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
    Route::post('/password/email', [Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
    Route::post('/password/reset', [Auth\ResetPasswordController::class, 'reset'])->name('reset');
  });

  Route::group(['prefix' => 'email', 'as' => 'verification.', 'middleware' => 'auth:api'], function () {
    Route::get('/email/resend', [Auth\VerificationController::class, 'resend'])->name('resend');
    Route::get('/email/verify/{userId}', [Auth\VerificationController::class, 'verify'])->name('verify');
  });
});

