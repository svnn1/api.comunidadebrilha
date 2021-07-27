<?php

namespace App\Repositories\Eloquent\User;

use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\User as Contracts;

/**
 * Class UserRepository
 *
 * @package App\Repositories\Eloquent\User
 */
class UserRepository extends BaseRepository implements Contracts\UserRepository
{
  /**
   * Model class for repository.
   *
   * @var string
   */
  protected string $model = User::class;
}
