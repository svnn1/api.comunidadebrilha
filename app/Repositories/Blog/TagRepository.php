<?php

namespace App\Repositories\Blog;

use App\Models\Blog\Tag;
use App\Repositories\BaseRepository;
use App\Contracts\Repositories\Blog as Contracts;

/**
 * Class TagRepository
 *
 * @package App\Repositories\Blog
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
