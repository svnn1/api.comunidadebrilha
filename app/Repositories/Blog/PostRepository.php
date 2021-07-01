<?php

namespace App\Repositories\Blog;

use App\Models\Blog\Tag;
use App\Models\Blog\Post;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Contracts\Repositories\Blog as Contracts;

/**
 * Class PostRepository
 *
 * @package App\Repositories\Blog
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
   * Add cover and tags for post.
   *
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $model
   */
  public function addCoverAndTags(Request $request, Model $model): void
  {
    $this->addCover($request, $model);
    $this->findOrCreateTags($request, $model);
  }

  /**
   * Add cover for post.
   *
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $model
   */
  public function addCover(Request $request, Model $model): void
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
  public function findOrCreateTags(Request $request, Model $model): void
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

  /**
   * Update cover for post.
   *
   * @param \Illuminate\Http\Request            $request
   * @param \Illuminate\Database\Eloquent\Model $model
   */
  public function updateCover(Request $request, Model $model): void
  {
    if ($request->hasFile('cover')) {
      if (isset($model->cover->url) && Storage::disk('public')->exists($model->cover->url)) {
        Storage::disk('public')->delete($model->cover->url);
      }

      $cover = $request->file('cover')->store('blog/posts', 'public');

      $model->cover()->update(['url' => $cover]);
    }
  }
}
