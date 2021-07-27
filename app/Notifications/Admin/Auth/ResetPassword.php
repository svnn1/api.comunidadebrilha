<?php

namespace App\Notifications\Admin\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class ResetPassword
 *
 * @package App\Notifications\Admin\Auth
 */
class ResetPassword extends Notification
{
  use Queueable;

  public string $link;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(string $link)
  {
    //
    $this->link = $link;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array
   */
  public function via(): array
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail(): MailMessage
  {
    return (new MailMessage())
      ->subject('Reset Password Notification')
      ->line('You are receiving this email because we received a password reset request for your account.')
      ->action('Reset Password', $this->link)
      ->line(__('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
      ->line('If you did not request a password reset, no further action is required.');
  }

  /**
   * Get the array representation of the notification.
   *
   * @return array
   */
  public function toArray(): array
  {
    return [];
  }
}
