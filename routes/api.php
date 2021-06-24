<?php

use App\Http\Controllers\Admin;
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

Route::group(['prefix' => 'auth'], function () {
  Route::post('/login', [Auth\LoginController::class, 'login'])->name('login');

  Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [Auth\LogoutController::class, 'logout'])->name('logout');
    Route::post('/refresh', [Auth\RefreshTokenController::class, 'refresh'])->name('refresh');
  });

  Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
    Route::post('/email', [Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
    Route::post('/reset', [Auth\ResetPasswordController::class, 'reset'])->name('reset');
  });

  Route::group(['prefix' => 'email', 'as' => 'verification.', 'middleware' => 'auth:api'], function () {
    Route::get('/resend', [Auth\VerificationController::class, 'resend'])->name('resend');
    Route::get('/verify/{userId}', [Auth\VerificationController::class, 'verify'])->name('verify');
  });
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:api']], function () {
  Route::group(['prefix' => 'users', 'as' => 'user.'], function () {
    Route::get('/', [Admin\UserController::class, 'index'])->name('index');
    Route::post('/', [Admin\UserController::class, 'store'])->name('store');
    Route::get('/{userId}', [Admin\UserController::class, 'show'])->name('show');
    Route::match(['patch', 'put'], '/{userId}', [Admin\UserController::class, 'update'])->name('update');
    Route::delete('/{userId}', [Admin\UserController::class, 'destroy'])->name('destroy');
  });

  Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
    Route::group(['prefix' => 'posts', 'as' => 'post.',], function () {
      Route::get('/', [Admin\Blog\PostController::class, 'index'])->name('index');
      Route::post('/', [Admin\Blog\PostController::class, 'store'])->name('store');
      Route::get('/{postId}', [Admin\Blog\PostController::class, 'show'])->name('show');
      Route::match(['patch', 'put'], '/{postId}', [Admin\Blog\PostController::class, 'update'])->name('update');
      Route::delete('/{postId}', [Admin\Blog\PostController::class, 'destroy'])->name('destroy');


      Route::match(['patch', 'put'], '/{postId}/status', [Admin\Blog\PostStatusController::class, 'update'])->name('status.update');
    });

    Route::group(['prefix' => 'tags', 'as' => 'tag.',], function () {
      Route::get('/', [Admin\Blog\TagController::class, 'index'])->name('index');
      Route::get('/{tagId}', [Admin\Blog\TagController::class, 'show'])->name('show');
    });
  });
});
