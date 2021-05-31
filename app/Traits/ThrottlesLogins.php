<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Cache\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Validation\ValidationException;

/**
 * Trait ThrottlesLogins
 *
 * @package App\Traits
 */
trait ThrottlesLogins
{
  /**
   * Determine if the user has too many failed login attempts.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return bool
   */
  protected function hasTooManyLoginAttempts(Request $request): bool
  {
    return $this->limiter()->tooManyAttempts(
      $this->throttleKey($request), $this->maxAttempts()
    );
  }

  /**
   * Increment the login attempts for the user.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return void
   */
  protected function incrementLoginAttempts(Request $request): void
  {
    $this->limiter()->hit(
      $this->throttleKey($request), $this->decayMinutes() * 60
    );
  }

  /**
   * Redirect the user after determining they are locked out.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return void
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  protected function sendLockoutResponse(Request $request): void
  {
    $seconds = $this->limiter()->availableIn(
      $this->throttleKey($request)
    );

    throw ValidationException::withMessages([
      $this->username() => [__('auth.throttle', [
        'seconds' => $seconds,
        'minutes' => ceil($seconds / 60),
      ])],
    ])->status(Response::HTTP_TOO_MANY_REQUESTS);
  }

  /**
   * Clear the login locks for the given user credentials.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return void
   */
  protected function clearLoginAttempts(Request $request): void
  {
    $this->limiter()->clear($this->throttleKey($request));
  }

  /**
   * Fire an event when a lockout occurs.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return void
   */
  protected function fireLockoutEvent(Request $request): void
  {
    event(new Lockout($request));
  }

  /**
   * Get the throttle key for the given request.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return string
   */
  protected function throttleKey(Request $request): string
  {
    return Str::lower($request->input($this->username())) . '|' . $request->ip();
  }

  /**
   * Get the rate limiter instance.
   *
   * @return \Illuminate\Cache\RateLimiter
   */
  protected function limiter(): RateLimiter
  {
    return app(RateLimiter::class);
  }

  /**
   * Get the maximum number of attempts to allow.
   *
   * @return int
   */
  public function maxAttempts(): int
  {
    return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
  }

  /**
   * Get the number of minutes to throttle for.
   *
   * @return int
   */
  public function decayMinutes(): int
  {
    return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1;
  }
}
