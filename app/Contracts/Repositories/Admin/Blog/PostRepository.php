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
   * Create cover for post.
   *
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $post
   */
  public function createCover(Request $request, Model $post);

  /**
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $post
   */
  public function findOrCreateTagsAndSyncPost(Request $request, Model $post): void;
}
