<?php

namespace App\Models;

use App\Models\Blog\Post;
use App\Traits\GenerateUuid;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Notifications\Admin\Auth\ResetPassword;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
  use GenerateUuid, HasFactory, HasRoles, Notifiable;

  /**
   * Set reset password route
   *
   *
   * @var string
   */
  public static string $resetPasswordRoute;

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'users';

  /**
   * The "type" of the primary key ID.
   *
   * @var string
   */
  protected $keyType = 'string';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  /**
   * Get all of the posts for the user.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function posts(): HasMany
  {
    return $this->hasMany(Post::class);
  }

  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims(): array
  {
    return [];
  }

  /**
   * Send the password reset notification.
   *
   * @param string $token
   *
   * @return void
   */
  public function sendPasswordResetNotification($token)
  {
    $link = str_replace('{token}', $token, self::$resetPasswordRoute);

    $this->notify(new ResetPassword($link));
  }
}
