<?php

namespace App\Http\Controllers\Blog;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\Blog\PostResource;
use App\Http\Resources\Blog\AuthorResource;
use App\Contracts\Repositories\Blog\PostRepository;
use App\Contracts\Repositories\Blog\AuthorRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Blog
 */
class AuthorController extends Controller
{
  /**
   * @var \App\Contracts\Repositories\Blog\AuthorRepository
   */
  private AuthorRepository $authorRepository;

  public function __construct(AuthorRepository $authorRepository)
  {
    $this->authorRepository = $authorRepository;
  }

  public function show(string $authorId)
  {
    $author = $this->authorRepository->find($authorId);


    return new AuthorResource($author->load('posts'));
  }
}
