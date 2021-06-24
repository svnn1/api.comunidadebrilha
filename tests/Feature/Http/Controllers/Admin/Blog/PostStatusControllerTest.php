<?php

namespace Tests\Feature\Http\Controllers\Admin\Blog;

use Tests\TestCase;
use App\Models\User;
use App\Models\Blog\Post;
use App\Enums\Admin\Blog\PostEnum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PostStatusControllerTest
 *
 * @package Tests\Feature\Http\Controllers\Admin\Blog
 */
class PostStatusControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testICanUpdateStatusForApprovedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->create();

    $this->patch(route('admin.blog.post.status.update', $post->id), [
      'status' => PostEnum::APPROVED,
    ])->assertOk();
  }

  public function testICanUpdateStatusForArchivedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->create();

    $this->patch(route('admin.blog.post.status.update', $post->id), [
      'status' => PostEnum::ARCHIVED,
    ])->assertOk();
  }

  public function testICanUpdateStatusForDraftedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->create();

    $this->patch(route('admin.blog.post.status.update', $post->id), [
      'status' => PostEnum::DRAFTED,
    ])->assertOk();
  }

  public function testICanUpdateStatusForPublishedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->create();

    $this->patch(route('admin.blog.post.status.update', $post->id), [
      'status' => PostEnum::PUBLISHED,
    ])->assertOk();
  }

  public function testICanUpdateStatusForRejectedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->create();

    $this->patch(route('admin.blog.post.status.update', $post->id), [
      'status' => PostEnum::REJECTED,
    ])->assertOk();
  }

  public function testICanUpdateStatusForSubmittedPost(): void
  {
    $user = User::factory()->create();

    $this->actingAs($user, 'api');

    $post = Post::factory()->published()->create();

    $this->patch(route('admin.blog.post.status.update', $post->id), [
      'status' => PostEnum::SUBMITTED,
    ])->assertOk();
  }
}
