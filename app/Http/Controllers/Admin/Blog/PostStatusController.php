<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Enums\Admin\Blog\PostEnum;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\Admin\Blog\PostRepository;
use App\Http\Requests\Admin\Blog\Post\UpdateStatusPostRequest;

/**
 * Class PostStatusController
 *
 * @package App\Http\Controllers\Admin\Blog
 */
class PostStatusController extends Controller
{
  /**
   * @var \App\Contracts\Repositories\Admin\Blog\PostRepository
   */
  private PostRepository $postRepository;

  public function __construct(PostRepository $postRepository)
  {
    $this->postRepository = $postRepository;
  }

  /**
   * Update status the specified post
   *
   * @param \App\Http\Requests\Admin\Blog\Post\UpdateStatusPostRequest $request
   * @param string                                                     $postId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function update(UpdateStatusPostRequest $request, string $postId): JsonResponse
  {
    $post = $this->postRepository->find($postId);

    match ($request->get('status')) {
      PostEnum::APPROVED,
      PostEnum::ARCHIVED,
      PostEnum::DRAFTED,
      PostEnum::REJECTED,
      PostEnum::SUBMITTED => $this->postRepository->update($post, ['status' => $request->get('status'), 'published_at' => null]),

      PostEnum::PUBLISHED => $this->postRepository->update($post, ['status' => PostEnum::PUBLISHED, 'published_at' => now()]),
    };

    return response()->json([
      'data' => $post,
    ], Response::HTTP_OK);
  }
}
