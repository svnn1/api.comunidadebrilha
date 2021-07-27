<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
  public function logout(): JsonResponse
  {
    auth('api')->logout();

    return response()->json([
      'data' => [
        'message' => __('You have successfully logged out.'),
      ],
    ], Response::HTTP_OK);
  }
}
