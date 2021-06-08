<?php

namespace Tests\Feature\Http\Controllers\Admin\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testUserCanLogout(): void
  {
    $user = User::factory()->create([
      'password' => bcrypt($password = 'i-love-laravel'),
    ]);

    $this->post(route('login'), [
      'email'    => $user->email,
      'password' => $password,
    ])->assertStatus(Response::HTTP_CREATED);

    $this->assertAuthenticated('api');
    $this->assertAuthenticatedAs($user, 'api');

    $this->post(route('logout'))->assertStatus(Response::HTTP_OK);
  }

  public function testUserCannotLogoutWhenNotAuthenticated(): void
  {
    $this->post(route('logout'))->assertStatus(Response::HTTP_UNAUTHORIZED);
  }
}
