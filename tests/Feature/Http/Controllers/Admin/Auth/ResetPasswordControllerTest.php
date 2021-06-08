<?php

namespace Tests\Feature\Http\Controllers\Admin\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testUserCanResetPasswordWithValidToken(): void
  {
    $user = User::factory()->create([
      'password' => bcrypt('old-password'),
    ]);

    $token = Password::broker()->createToken($user);

    $this->post(route('password.reset'), [
      'token'                 => $token,
      'email'                 => $user->email,
      'password'              => 'new-awesome-password',
      'password_confirmation' => 'new-awesome-password',
    ])->assertStatus(Response::HTTP_OK);
  }

  public function testUserCannotResetPasswordWithInvalidToken(): void
  {
    $user = User::factory()->create([
      'password' => bcrypt('old-password'),
    ]);

    $this->post(route('password.reset'), [
      'token'                 => 'invalid-token',
      'email'                 => $user->email,
      'password'              => 'new-awesome-password',
      'password_confirmation' => 'new-awesome-password',
    ])->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
  }

  public function testUserCannotResetPasswordWithoutProvidingANewPassword(): void
  {
    $user = User::factory()->create([
      'password' => bcrypt('old-password'),
    ]);

    $token = Password::broker()->createToken($user);

    $this->post(route('password.reset'), [
      'token'                 => $token,
      'email'                 => $user->email,
      'password'              => '',
      'password_confirmation' => '',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  public function testUserCannotResetPasswordWithoutProvidingAnEmail(): void
  {
    $user = User::factory()->create([
      'password' => bcrypt('old-password'),
    ]);

    $token = Password::broker()->createToken($user);

    $this->post(route('password.reset'), [
      'token'                 => $token,
      'email'                 => '',
      'password'              => 'new-awesome-password',
      'password_confirmation' => 'new-awesome-password',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }
}
