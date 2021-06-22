<?php

namespace Http\Controllers\Admin\Blog;

use Tests\TestCase;
use App\Models\User;
use App\Models\Blog\Tag;
use App\Models\Blog\Post;
use App\Models\Blog\Image;
use Illuminate\Http\UploadedFile;
use App\Enums\Admin\Blog\PostEnum;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PostControllerTest
 *
 * @package Http\Controllers\Admin\Blog
 */
class PostControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testICanSeeAllPosts(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $this->get(route('blog.post.index'))->assertOk();
  }

  public function testCanCreateAPost(): void
  {
    Storage::fake('public');

    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $this->post(route('blog.post.store'), $data = [
      'title'   => $this->faker->title,
      'summary' => $this->faker->sentence,
      'content' => $this->faker->paragraph,
      'user_id' => $user->id,
      'cover'   => UploadedFile::fake()->create('cover.png'),
      'tags'    => Tag::factory()->count(5)->create()->toArray(),
    ])->assertCreated();

    $this->assertDatabaseHas('posts', [
      'title' => $data['title'],
    ]);
  }

  public function testCanSeeOnePost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()
      ->has(Image::factory(), 'cover')
      ->has(Tag::factory(), 'tags')
      ->create();

    $this->get(route('blog.post.show', $post->id))->assertOk();
  }

  public function testCanUpdatePost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()
      ->has(Image::factory(), 'cover')
      ->has(Tag::factory(), 'tags')
      ->create();

    $this->patch(route('blog.post.update', $post->id), $data = [
      'title' => $this->faker->title,
    ])->assertOk();

    $this->assertDatabaseHas('posts', [
      'title' => $data['title'],
    ]);
  }

  public function testCanDeletePost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->has(Image::factory(), 'cover')->create();

    $this->delete(route('blog.post.destroy', $post->id))->assertNoContent();
  }

  public function testICanUpdateStatusForApprovedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->create();

    $this->patch(route('blog.post.updateStatus', $post->id), [
      'status' => PostEnum::APPROVED,
    ])->assertOk();
  }

  public function testICanUpdateStatusForArchivedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->create();

    $this->patch(route('blog.post.updateStatus', $post->id), [
      'status' => PostEnum::ARCHIVED,
    ])->assertOk();
  }

  public function testICanUpdateStatusForDraftedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->create();

    $this->patch(route('blog.post.updateStatus', $post->id), [
      'status' => PostEnum::DRAFTED,
    ])->assertOk();
  }

  public function testICanUpdateStatusForPublishedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->create();

    $this->patch(route('blog.post.updateStatus', $post->id), [
      'status' => PostEnum::PUBLISHED,
    ])->assertOk();
  }

  public function testICanUpdateStatusForRejectedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->create();

    $this->patch(route('blog.post.updateStatus', $post->id), [
      'status' => PostEnum::REJECTED,
    ])->assertOk();
  }

  public function testICanUpdateStatusForSubmittedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->create();

    $this->patch(route('blog.post.updateStatus', $post->id), [
      'status' => PostEnum::SUBMITTED,
    ])->assertOk();
  }
}
