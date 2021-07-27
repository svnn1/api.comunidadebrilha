<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts as Contracts;
use App\Repositories\Eloquent as Repositories;

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
    Contracts\BaseRepository::class           => Repositories\BaseRepository::class,
    Contracts\User\UserRepository::class      => Repositories\User\UserRepository::class,
    Contracts\User\AuthorRepository::class    => Repositories\User\AuthorRepository::class,
    Contracts\Acl\RoleRepository::class       => Repositories\Acl\RoleRepository::class,
    Contracts\Acl\PermissionRepository::class => Repositories\Acl\PermissionRepository::class,
    Contracts\Blog\PostRepository::class      => Repositories\Blog\PostRepository::class,
    Contracts\Blog\TagRepository::class       => Repositories\Blog\TagRepository::class,
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
