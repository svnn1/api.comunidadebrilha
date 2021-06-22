<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Enums\Admin\Blog\PostEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Blog\PostResource;
use App\Http\Requests\Admin\Blog\Post\StorePostRequest;
use App\Http\Requests\Admin\Blog\Post\UpdatePostRequest;
use App\Contracts\Repositories\Admin\Blog\PostRepository;
use App\Http\Requests\Admin\Blog\Post\UpdateStatusPostRequest;

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
    $posts = $this->postRepository->newQuery()->with([
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
    $data['user_id'] = auth('api')->user()->id;

    $post = $this->postRepository->create($data);

    if ($request->hasFile('cover')) {
      $cover = $request->file('cover')->store('blog/posts', 'public');

      $post->cover()->create(['url' => $cover]);
    }

    $this->postRepository->findOrCreateTagsAndSyncPost($request, $post);

    return response()->json([
      'data' => $post,
    ], Response::HTTP_CREATED);
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

    return response()->json([
      'data' => $post,
    ], Response::HTTP_OK);
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
    $this->postRepository->findOrCreateTagsAndSyncPost($request, $post);

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

    Storage::disk('public')->delete($post->cover->url);

    return response()->json([], Response::HTTP_NO_CONTENT);
  }

  public function updateStatus(UpdateStatusPostRequest $request, string $postId): JsonResponse
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