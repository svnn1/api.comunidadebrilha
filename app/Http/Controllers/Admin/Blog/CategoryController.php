<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * Class CategoryController
 *
 * @package App\Http\Controllers\Admin\Blog
 */
class CategoryController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(): JsonResponse
  {
    return response()->json();
  }
}
