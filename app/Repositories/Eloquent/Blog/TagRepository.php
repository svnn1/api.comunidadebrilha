<?php

namespace App\Repositories\Eloquent\Blog;

use App\Models\Blog\Tag;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\Blog as Contracts;

/**
 * Class TagRepository
 *
 * @package App\Repositories\Eloquent\Blog
 */
class TagRepository extends BaseRepository implements Contracts\TagRepository
{
  /**
   * Model class for repository.
   *
   * @var string
   */
  protected string $model = Tag::class;
}
