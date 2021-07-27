<?php

namespace App\Repositories\Contracts\Blog;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BaseRepository;

/**
 * Interface PostRepository
 *
 * @package App\Repositories\Contracts\Blog
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
  public function addCover(Request $request, Model $model);

  /**
   * Update cover for post.
   *
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $model
   */
  public function updateCover(Request $request, Model $model): void;

  /**
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $model
   */
  public function findOrCreateTags(Request $request, Model $model): void;
}
