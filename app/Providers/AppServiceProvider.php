<?php

namespace App\Providers;

use App\Repositories as Repositories;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories as Contracts;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(Contracts\BaseRepository::class, Repositories\BaseRepository::class);
    $this->app->bind(Contracts\Admin\UserRepository::class, Repositories\Admin\UserRepository::class);
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
