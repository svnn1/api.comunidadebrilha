<?php

namespace Tests\Feature\Http\Controllers\Admin\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use App\Notifications\Admin\Auth\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testUserReceivesAnEmailWithAPasswordResetLink(): void
  {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), [
      'email' => $user->email,
      'url'   => 'https://www.jtrarcondicionado.com.br/{token}',
    ])->assertStatus(Response::HTTP_OK);

    $token = DB::table('password_resets')
      ->where('email', '=', $user->email)
      ->first();

    $this->assertNotNull($token);

    $this->assertDatabaseHas('password_resets', [
      'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($token) {
      return Hash::check(Str::afterLast($notification->link, '/'), $token->token);
    });
  }

  public function testUserDoesNotReceiveEmailWhenNotRegistered(): void
  {
    Notification::fake();

    $this->post(route('password.email'), [
      'email' => 'contact@svndev.com.br',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    Notification::assertNotSentTo(User::factory()->make([
      'email' => 'nobody@example.com',
    ]), ResetPassword::class);
  }

  public function testEmailIsRequired(): void
  {
    $this->post(route('password.email'), [
      'email' => '',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson([
        'error' => [
          'status'  => Response::HTTP_UNPROCESSABLE_ENTITY,
          'message' => 'The given data was invalid.',
          'errors'  => [
            'email' => [
              0 => 'The email field is required.',
            ],
          ],
        ],
      ]);
  }

  public function testEmailIsAInvalidEmail(): void
  {
    $this->post(route('password.email'), [
      'email' => 'invalid-email',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson([
        'error' => [
          'status'  => Response::HTTP_UNPROCESSABLE_ENTITY,
          'message' => 'The given data was invalid.',
          'errors'  => [
            'email' => [
              0 => 'The email must be a valid email address.',
            ],
          ],
        ],
      ]);
  }
}
