<?php

namespace Tests\Feature\Http\Controllers\Admin\Blog;

use Tests\TestCase;
use App\Models\User;
use App\Models\Blog\Tag;
use App\Models\Blog\Post;
use App\Models\Blog\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PostCoverControllerTest
 *
 * @package Tests\Feature\Http\Controllers\Admin\Blog
 */
class PostCoverControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testCanUpdateCover()
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()
      ->has(Image::factory(), 'cover')
      ->has(Tag::factory(), 'tags')
      ->create();

    $this->post(route('admin.blog.post.cover.update', $post->id), $data = [
      'cover' => UploadedFile::fake()->create('cover.png'),
    ])->assertOk();

    $this->assertDatabaseHas('images', [
      'id'  => $post->cover->id,
      'url' => "blog/posts/{$data['cover']->hashName()}",
    ]);
  }
}
