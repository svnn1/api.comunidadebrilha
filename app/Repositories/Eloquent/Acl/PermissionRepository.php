<?php

namespace App\Repositories\Eloquent\Acl;

use App\Models\Admin\Acl\Permission;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\Acl as Contracts;

/**
 * Class PermissionRepository
 *
 * @package App\Repositories\Eloquent\Acl
 */
class PermissionRepository extends BaseRepository implements Contracts\PermissionRepository
{
  /**
   * Model class for repository.
   *
   * @var string
   */
  protected string $model = Permission::class;
}
