<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Admin\Blog\PostResource;
use App\Http\Requests\Admin\Blog\Post\StorePostRequest;
use App\Http\Requests\Admin\Blog\Post\UpdatePostRequest;
use App\Contracts\Repositories\Admin\Blog\PostRepository;

/**
 * Class PostController
 *
 * @package App\Http\Controllers\Admin\Blog
 */
class PostController extends Controller
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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function index(): JsonResponse
  {
    $posts = $this->postRepository->withRelationships([
      'author', 'cover', 'tags',
    ])->paginate();

    return PostResource::collection($posts)
      ->response()
      ->setStatusCode(Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \App\Http\Requests\Admin\Blog\Post\StorePostRequest $request
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function store(StorePostRequest $request): JsonResponse
  {
    $data = $request->validated();
    $data['user_id'] = auth('api')->id();

    $post = $this->postRepository->create($data);

    $this->postRepository->addCoverAndTags($request, $post);

    return (new PostResource($post->load(['cover', 'tags'])))
      ->response()
      ->setStatusCode(Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param string $postId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function show(string $postId): JsonResponse
  {
    $post = $this->postRepository->find($postId);

    return (new PostResource($post->load(['cover', 'tags'])))
      ->response()
      ->setStatusCode(Response::HTTP_CREATED);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \App\Http\Requests\Admin\Blog\Post\UpdatePostRequest $request
   * @param string                                               $postId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function update(UpdatePostRequest $request, string $postId): JsonResponse
  {
    $post = $this->postRepository->find($postId);

    $this->postRepository->update($post, $request->validated());
    $this->postRepository->findOrCreateTags($request, $post);

    return response()->json([
      'data' => $post,
    ], Response::HTTP_OK);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param string $postId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception|\Illuminate\Contracts\Container\BindingResolutionException
   */
  public function destroy(string $postId): JsonResponse
  {
    $post = $this->postRepository->find($postId);

    $this->postRepository->delete($post);

    if (isset($post->cover->url) || Storage::disk('public')->exists($post->cover->url)) {
      Storage::disk('public')->delete($post->cover->url);
    }

    return response()->json([], Response::HTTP_NO_CONTENT);
  }
}
