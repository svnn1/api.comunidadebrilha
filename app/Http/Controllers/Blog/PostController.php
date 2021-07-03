<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blog\PostResource;
use App\Repositories\Contracts\Blog\PostRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class PostController
 *
 * @package App\Http\Controllers\Blog
 */
class PostController extends Controller
{
  /**
   * @var \App\Repositories\Contracts\Blog\PostRepository
   */
  private PostRepository $postRepository;

  public function __construct(PostRepository $postRepository)
  {
    $this->postRepository = $postRepository;
  }

  /**
   * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function index(): AnonymousResourceCollection
  {
    $posts = $this->postRepository->findWhere([
      'status' => 'published',
      ['published_at', '!=', null],
    ])->with(['author', 'cover', 'tags'])->filter()->orderByDesc('published_at')->paginate();

    return PostResource::collection($posts);
  }

  /**
   * @param string $postSlug
   *
   * @return \App\Http\Resources\Blog\PostResource
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function show(string $postSlug): PostResource
  {
    $post = $this->postRepository->findWhere([
      'slug'   => $postSlug,
      'status' => 'published',
      ['published_at', '!=', null],
    ])->with(['author', 'cover', 'tags'])->firstOrFail();

    return new PostResource($post);
  }
}
