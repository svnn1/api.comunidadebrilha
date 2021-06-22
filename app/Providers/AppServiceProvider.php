<?php

namespace App\Providers;

use App\Repositories as Repositories;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories as Contracts;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
  /**
   * All of the container bindings that should be registered.
   *
   * @var array
   */
  public array $bindings = [
    Contracts\BaseRepository::class                 => Repositories\BaseRepository::class,
    Contracts\Admin\UserRepository::class           => Repositories\Admin\UserRepository::class,
    Contracts\Admin\Acl\RoleRepository::class       => Repositories\Admin\Acl\RoleRepository::class,
    Contracts\Admin\Acl\PermissionRepository::class => Repositories\Admin\Acl\PermissionRepository::class,
    Contracts\Admin\Blog\PostRepository::class      => Repositories\Admin\Blog\PostRepository::class,
    Contracts\Admin\Blog\TagRepository::class       => Repositories\Admin\Blog\TagRepository::class,
  ];

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
  }
}
