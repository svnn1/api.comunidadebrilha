<?php

namespace App\Repositories\Blog;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Contracts\Repositories\Blog as Contracts;

/**
 * Class AuthorRepository
 *
 * @package App\Repositories\Blog
 */
class AuthorRepository extends BaseRepository implements Contracts\AuthorRepository
{
  /**
   * Model class for repository.
   *
   * @var string
   */
  protected string $model = User::class;
}
