<?php

namespace App\Repositories\Eloquent\Acl;

use App\Models\Admin\Acl\Role;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\Acl as Contracts;

/**
 * Class RoleRepository
 *
 * @package App\Repositories\Eloquent\Acl
 */
class RoleRepository extends BaseRepository implements Contracts\RoleRepository
{
  /**
   * Model class for repository.
   *
   * @var string
   */
  protected string $model = Role::class;
}
