<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\Admin\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
  /**
   * Reset password.
   *
   * @param \App\Http\Requests\Admin\Auth\ResetPasswordRequest $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function reset(ResetPasswordRequest $request): JsonResponse
  {
    $response = Password::broker()->reset(
      $request->only(
        'email', 'password', 'password_confirmation', 'token'
      ), function ($user) use ($request) {
      $user->password = bcrypt($request->get('password'));
      $user->setRememberToken(Str::random(60));
      $user->save();

      event(new PasswordReset($user));
    });

    return $response == Password::PASSWORD_RESET
      ? $this->sendResetResponse($request, $response)
      : $this->sendResetFailedResponse($request, $response);
  }

  /**
   * Get the response for a successful password reset.
   *
   * @param \Illuminate\Http\Request $request
   * @param string                   $response
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function sendResetResponse(Request $request, string $response): JsonResponse
  {
    return response()->json([
      'data' => [
        'message' => __($response),
      ],
    ], Response::HTTP_OK);
  }

  /**
   * Get the response for a failed password reset.
   *
   * @param \Illuminate\Http\Request $request
   * @param string                   $response
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function sendResetFailedResponse(Request $request, string $response): JsonResponse
  {
    return response()->json([
      'error' => [
        'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
        'message' => __($response),
      ],
    ], Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
