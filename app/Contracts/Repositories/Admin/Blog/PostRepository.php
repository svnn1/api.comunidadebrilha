<?php

namespace App\Contracts\Repositories\Admin\Blog;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Repositories\BaseRepository;

/**
 * Interface PostRepository
 *
 * @package App\Contracts\Repositories\Admin\Blog
 */
interface PostRepository extends BaseRepository
{
  /**
   * Add cover and tags for post.
   *
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $model
   */
  public function addCoverAndTags(Request $request, Model $model): void;

  /**
   * Create cover for post.
   *
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $model
   */
  public function createCover(Request $request, Model $model);

  /**
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $model
   */
  public function findOrCreateTagsAndSyncPost(Request $request, Model $model): void;
}
