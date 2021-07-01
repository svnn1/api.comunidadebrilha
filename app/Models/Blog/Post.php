<?php

namespace App\Models\Blog;

use App\Models\User;
use App\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class Post
 *
 * @package App\Models
 */
class Post extends Model
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
  protected $table = 'posts';

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
    'title', 'summary', 'content', 'status', 'user_id', 'published_at',
  ];

  /**
   * @param \Illuminate\Database\Eloquent\Builder $query
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopePublished(Builder $query): Builder
  {
    return $query->where('status', '=', 'published')->where('published_at', '!=', null);
  }

  /**
   * Get the post's author.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function author(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * Get all of the tags for the post.
   *
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function tags(): MorphToMany
  {
    return $this->morphToMany(Tag::class, 'taggable');
  }

  /**
   * Get the post's photo.
   *
   * @return \Illuminate\Database\Eloquent\Relations\MorphOne
   */
  public function cover(): MorphOne
  {
    return $this->morphOne(Image::class, 'imageable');
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
        'source' => 'title',
      ],
    ];
  }
}
