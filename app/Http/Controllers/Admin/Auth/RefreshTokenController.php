<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class RefreshTokenController extends Controller
{
  public function refresh(): JsonResponse
  {
    $token = auth('api')->refresh();

    return response()->json([
      'data' => [
        'access_token' => $token,
        'token_type'   => 'Bearer',
        'expires_in'   => auth('api')->factory()->getTTL() * 60,
      ],
    ], Response::HTTP_CREATED);
  }
}
