<?php

namespace App\Repositories\Admin\Blog;

use App\Models\Blog\Tag;
use App\Repositories\BaseRepository;
use App\Contracts\Repositories\Admin\Blog as Contracts;

/**
 * Class TagRepository
 *
 * @package App\Repositories\Admin\Blog
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
