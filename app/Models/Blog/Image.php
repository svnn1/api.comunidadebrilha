<?php

namespace App\Models\Blog;

use App\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Image
 *
 * @package App\Models\Blog
 */
class Image extends Model
{
  use GenerateUuid, HasFactory;

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
  protected $table = 'images';

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
    'url',
  ];

  /**
   * Get the parent imageable model.
   *
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function imageable(): MorphTo
  {
    return $this->morphTo();
  }
}
