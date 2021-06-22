<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\Admin\Blog\TagRepository;

/**
 * Class TagController
 *
 * @package App\Http\Controllers\Admin\Blog
 */
class TagController extends Controller
{
  /**
   * @var \App\Contracts\Repositories\Admin\Blog\TagRepository
   */
  private TagRepository $tagRepository;

  public function __construct(TagRepository $tagRepository)
  {
    $this->tagRepository = $tagRepository;
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function index(): JsonResponse
  {
    $tags = $this->tagRepository->all();

    return response()->json([
      'data' => $tags,
    ], Response::HTTP_OK);
  }

  public function show(string $tagId)
  {
    $tag = $this->tagRepository->find($tagId);

    return response()->json(['data' => $tag], Response::HTTP_OK);
  }
}
