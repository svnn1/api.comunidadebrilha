<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\Blog\PostRepository;
use App\Http\Requests\Admin\Blog\Post\UpdatePostCoverRequest;

/**
 * Class PostCoverController
 *
 * @package App\Http\Controllers\Admin\Blog
 */
class PostCoverController extends Controller
{
  //TODO: Não sei se cover é um bom nome, estou pensando em alterar, só não o que colocar ainda...
  /**
   * @var \App\Contracts\Repositories\Blog\PostRepository
   */
  private PostRepository $postRepository;

  public function __construct(PostRepository $postRepository)
  {
    $this->postRepository = $postRepository;
  }

  /**
   * @param \App\Http\Requests\Admin\Blog\Post\UpdatePostCoverRequest $request
   * @param string                                                    $postId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function update(UpdatePostCoverRequest $request, string $postId): JsonResponse
  {
    $post = $this->postRepository->find($postId);

    $this->postRepository->updateCover($request, $post);

    return response()->json([
      'data' => $post->load('cover'),
    ], Response::HTTP_OK);
  }
}
