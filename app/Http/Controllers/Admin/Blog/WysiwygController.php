<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * Class WysiwygController
 *
 * @package App\Http\Controllers\Admin\Blog
 */
class WysiwygController extends Controller
{
  public function store(Request $request): JsonResponse
  {
    $file = $request->file('upload')->store('blog/posts/wysiwyg', 'public');

    $url = asset("storage/{$file}");

    return response()->json(['url' => $url], Response::HTTP_OK);
  }
}
