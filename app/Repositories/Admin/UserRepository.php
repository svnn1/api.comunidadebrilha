<?php

namespace App\Repositories\Admin;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Contracts\Repositories\Admin as Contracts;

/**
 * Class UserRepository
 *
 * @package App\Repositories\Admin
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
