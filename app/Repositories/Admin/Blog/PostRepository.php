<?php

namespace App\Repositories\Admin\Blog;

use App\Models\Blog\Tag;
use App\Models\Blog\Post;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Repositories\Admin\Blog as Contracts;

/**
 * Class PostRepository
 *
 * @package App\Repositories\Admin\Blog
 */
class PostRepository extends BaseRepository implements Contracts\PostRepository
{
  /**
   * Model class for repository.
   *
   * @var string
   */
  protected string $model = Post::class;

  /**
   * Create cover for post.
   *
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $model
   */
  public function createCover(Request $request, Model $model): void
  {
    if ($request->hasFile('cover')) {
      $cover = $request->file('cover')->store('blog/posts', 'public');

      $model->cover()->create(['url' => $cover]);
    }
  }

  /**
   * Find or create new tags and sync with post.
   *
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $model
   */
  public function findOrCreateTagsAndSyncPost(Request $request, Model $model): void
  {
    if ($request->has('tags')) {
      $tags = [];

      foreach ($request->get('tags') as $tag) {
        $data = Tag::firstOrCreate(['name' => $tag]);

        $tags[] = $data->id;
      }

      $model->tags()->sync($tags);
    }
  }
}
