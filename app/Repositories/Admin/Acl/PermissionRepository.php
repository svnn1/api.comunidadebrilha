<?php

namespace App\Repositories\Admin\Acl;

use App\Repositories\BaseRepository;
use App\Models\Admin\Acl\Permission;
use App\Contracts\Repositories\Admin\Acl as Contracts;

/**
 * Class PermissionRepository
 *
 * @package App\Repositories\Admin\Acl
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
