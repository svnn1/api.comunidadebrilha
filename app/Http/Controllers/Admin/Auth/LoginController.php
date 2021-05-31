<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ThrottlesLogins;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;

class LoginController extends Controller
{
  use ThrottlesLogins;

  public function login(LoginRequest $request): JsonResponse
  {
    if ($this->hasTooManyLoginAttempts($request)) {
      $this->fireLockoutEvent($request);

      return $this->sendLockoutResponse($request);
    }

    $credentials = $request->only('email', 'password');

    $token = auth('api')->attempt($credentials);

    if (!$token) {
      $this->incrementLoginAttempts($request);

      return response()->json([
        'error' => [
          'status'  => Response::HTTP_UNAUTHORIZED,
          'message' => __('auth.failed'),
        ],
      ], Response::HTTP_UNAUTHORIZED);
    }

    return response()->json([
      'data' => [
        'access_token' => $token,
        'token_type'   => 'Bearer',
        'expires_in'   => auth('api')->factory()->getTTL() * 60,
      ],
    ], Response::HTTP_CREATED);
  }

  public function username(): string
  {
    return 'email';
  }

  protected function sendLockoutResponse(Request $request): JsonResponse
  {
    $seconds = $this->limiter()->availableIn(
      $this->throttleKey($request)
    );

    return response()->json([
      'error' => [
        'status'  => Response::HTTP_TOO_MANY_REQUESTS,
        'message' => __('auth.throttle', ['seconds' => $seconds]),
      ],
    ], Response::HTTP_TOO_MANY_REQUESTS);
  }
}
