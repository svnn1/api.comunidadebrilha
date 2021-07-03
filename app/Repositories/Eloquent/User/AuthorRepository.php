<?php

namespace App\Repositories\Eloquent\User;

use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\User as Contracts;

/**
 * Class AuthorRepository
 *
 * @package App\Repositories\Eloquent\User
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
