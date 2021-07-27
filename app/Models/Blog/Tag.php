<?php

namespace App\Models\Blog;

use App\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class Tag
 *
 * @package App\Models\Admin\Blog
 */
class Tag extends Model
{
  use GenerateUuid, HasFactory, Sluggable;

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
  protected $table = 'tags';

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
    'name', 'slug'
  ];

  /**
   * Get all of the posts that are assigned this tag.
   *
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function posts(): MorphToMany
  {
    return $this->morphedByMany(Post::class, 'taggable');
  }

  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable(): array
  {
    return [
      'slug' => [
        'source' => 'name',
      ],
    ];
  }
}
