<?php

namespace Tests\Feature\Http\Controllers\Admin\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerificationControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testUserCannotVerifyOthers(): void
  {
    $user = User::factory()->create([
      'email_verified_at' => null,
    ]);

    $otherUser = User::factory()->create([
      'email_verified_at' => null,
    ]);

    $this->actingAs($user, 'api')
      ->get($this->validVerificationVerifyRoute($otherUser))
      ->assertStatus(Response::HTTP_FORBIDDEN);

    $this->assertFalse($otherUser->fresh()->hasVerifiedEmail());
  }

  public function testForbiddenIsReturnedWhenSignatureIsInvalidInVerificationVerifyRoute(): void
  {
    $user = User::factory()->create([
      'email_verified_at' => now(),
    ]);

    $this->actingAs($user, 'api')
      ->get($this->invalidVerificationVerifyRoute($user))
      ->assertStatus(Response::HTTP_FORBIDDEN);
  }

  public function testUserCanVerifyYourself(): void
  {
    $user = User::factory()->create([
      'email_verified_at' => null,
    ]);

    $this->actingAs($user, 'api')
      ->get($this->validVerificationVerifyRoute($user))
      ->assertStatus(Response::HTTP_OK);

    $this->assertNotNull($user->fresh()->email_verified_at);
  }

  public function testGuestCannotResendAVerificationEmail(): void
  {
    $this->get($this->verificationResendRoute())
      ->assertStatus(Response::HTTP_UNAUTHORIZED);
  }

  public function testUserCanResendAVerificationEmail(): void
  {
    Notification::fake();

    $user = User::factory()->create([
      'email_verified_at' => null,
    ]);

    $this->actingAs($user, 'api')
      ->get($this->verificationResendRoute());

    Notification::assertSentTo($user, VerifyEmail::class);
  }

  private function validVerificationVerifyRoute(User $user): string
  {
    return URL::signedRoute('verification.verify', [
      'userId' => $user->id,
      'hash'   => sha1($user->getEmailForVerification()),
    ]);
  }

  private function invalidVerificationVerifyRoute(User $user): string
  {
    return route('verification.verify', [
      'userId' => $user->id,
      'hash'   => 'invalid-hash',
    ]);
  }

  private function verificationResendRoute(): string
  {
    return route('verification.resend');
  }
}
