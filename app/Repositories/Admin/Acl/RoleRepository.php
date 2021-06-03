<?php

namespace App\Repositories\Admin\Acl;

use App\Models\Admin\Acl\Role;
use App\Repositories\BaseRepository;
use App\Contracts\Repositories\Admin\Acl as Contracts;

/**
 * Class RoleRepository
 *
 * @package App\Repositories\Admin\Acl
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
