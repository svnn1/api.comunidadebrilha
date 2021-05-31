<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Admin\Auth\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
  /**
   * Send reset link email.
   *
   * @param \App\Http\Requests\Admin\Auth\ForgotPasswordRequest $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function sendResetLinkEmail(ForgotPasswordRequest $request): JsonResponse
  {
    //Users::$resetPasswordRoute = $request->get('url');

    $response = Password::broker()->sendResetLink(
      $request->only('email')
    );

    return $response == Password::RESET_LINK_SENT
      ? $this->sendResetLinkResponse($response)
      : $this->sendResetLinkFailedResponse($request, $response);
  }

  /**
   * Get the response for a successful password reset link.
   *
   * @param string $response
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function sendResetLinkResponse(string $response): JsonResponse
  {
    return response()->json([
      'data' => [
        'message' => __($response),
      ],
    ], Response::HTTP_OK);
  }

  /**
   * Get the response for a failed password reset link.
   *
   * @param \Illuminate\Http\Request $request
   * @param string                   $response
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function sendResetLinkFailedResponse(Request $request, string $response): JsonResponse
  {
    return response()->json([
      'error' => [
        'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
        'message' => __($response),
      ],
    ], Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
