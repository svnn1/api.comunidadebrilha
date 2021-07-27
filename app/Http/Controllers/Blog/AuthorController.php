<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blog\AuthorResource;
use App\Repositories\Contracts\User\AuthorRepository;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Blog
 */
class AuthorController extends Controller
{
  /**
   * @var \App\Repositories\Contracts\User\AuthorRepository
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
