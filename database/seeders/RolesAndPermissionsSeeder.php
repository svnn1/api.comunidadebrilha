<?php

namespace Database\Seeders;

use App\Models\Admin\Acl\Role;
use Illuminate\Database\Seeder;
use App\Models\Admin\Acl\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // create permissions
    Permission::create(['name' => 'edit articles', 'guard_name' => 'api']);
    Permission::create(['name' => 'delete articles', 'guard_name' => 'api']);
    Permission::create(['name' => 'publish articles', 'guard_name' => 'api']);
    Permission::create(['name' => 'unpublish articles', 'guard_name' => 'api']);

    // create roles and assign created permissions

    // this can be done as separate statements
    $role = Role::create(['name' => 'writer', 'guard_name' => 'api']);
    $role->givePermissionTo('edit articles');

    // or may be done by chaining
    Role::create(['name' => 'moderator', 'guard_name' => 'api'])
      ->givePermissionTo(['publish articles', 'unpublish articles']);

    $role = Role::create(['name' => 'super-admin', 'guard_name' => 'api']);
    $role->givePermissionTo(Permission::all());
  }
}
