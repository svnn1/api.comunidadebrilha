<?php

namespace Tests\Feature\Http\Controllers\Admin\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class LoginControllerTest
 *
 * @package Tests\Feature\Http\Controllers\Admin\Auth
 */
class LoginControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testUserCanLoginWithCorrectCredentials(): void
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
  }

  public function testUserCannotLoginWithIncorrectPassword(): void
  {
    $user = User::factory()->create();

    $response = $this->post(route('login'), [
      'email'    => $user->email,
      'password' => 'invalid-password',
    ])->assertStatus(Response::HTTP_UNAUTHORIZED);

    $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson([
      'error' => [
        'message' => "These credentials do not match our records.",
      ],
    ]);
  }

  public function testUserCannotLoginWithEmailThatDoesNotExist(): void
  {
    $response = $this->post(route('login'), [
      'email'    => 'silvano@svndev.com.br',
      'password' => 'invalid-password',
    ])->assertStatus(Response::HTTP_UNAUTHORIZED);

    $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson([
      'error' => [
        'message' => "These credentials do not match our records.",
      ],
    ]);
  }

  public function testUserCannotMakeMoreThanFiveAttemptsInOneMinute(): void
  {
    $user = User::factory()->create([
      'password' => bcrypt('i-love-laravel'),
    ]);

    $response = null;

    foreach (range(0, 5) as $attempt) {
      $response = $this->post(route('login'), [
        'email'    => $user->email,
        'password' => 'invalid-password',
      ]);
    }

    $response->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);
  }
}
