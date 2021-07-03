<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationController extends Controller
{
  /**
   * VerificationController constructor.
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('signed')->only('verify');
    $this->middleware('throttle:6,1')->only('verify', 'resend');
  }

  /**
   * Mark the authenticated user's email address as verified.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Auth\Access\AuthorizationException
   */
  public function verify(Request $request): JsonResponse
  {
    if ($request->route('user') != $request->user()->getKey()) {
      throw new AuthorizationException;
    }

    if ($request->user()->hasVerifiedEmail()) {
      return response()->json([
        'data' => [
          'message' => __('Your email is already verified.'),
        ],
      ], Response::HTTP_OK);
    }

    if ($request->user()->markEmailAsVerified()) {
      event(new Verified($request->user()));
    }

    return response()->json([
      'data' => [
        'message' => __('Your email has been successfully verified.'),
      ],
    ], Response::HTTP_OK);
  }

  /**
   * Resend the email verification notification.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function resend(Request $request): JsonResponse
  {
    if ($request->user()->hasVerifiedEmail()) {
      return response()->json([
        'data' => [
          'message' => __('Your email is already verified.'),
        ],
      ], Response::HTTP_OK);
    }

    $request->user()->sendEmailVerificationNotification();

    return response()->json([
      'data' => [
        'message' => __('Verification email sent successfully.'),
      ],
    ], Response::HTTP_OK);
  }
}
