<?php

namespace Database\Factories\Blog;

use App\Models\User;
use App\Models\Blog\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class PostFactory
 *
 * @package Database\Factories\Blog
 */
class PostFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Post::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'title'   => $this->faker->sentence,
      'summary' => $this->faker->sentence,
      'content' => $this->faker->paragraph,
      'user_id' => User::factory(),
    ];
  }

  /**
   * Indicate that post is approved.
   *
   * @return \Database\Factories\Blog\PostFactory
   */
  public function approved(): PostFactory
  {
    return $this->state(function (array $attributes) {
      return [
        'status' => 'approved',
      ];
    });
  }

  /**
   * Indicate that post is archived.
   *
   * @return \Database\Factories\Blog\PostFactory
   */
  public function archived(): PostFactory
  {
    return $this->state(function (array $attributes) {
      return [
        'status' => 'archived',
      ];
    });
  }

  /**
   * Indicate that post is drafted.
   *
   * @return \Database\Factories\Blog\PostFactory
   */
  public function drafted(): PostFactory
  {
    return $this->state(function (array $attributes) {
      return [
        'status' => 'drafted',
      ];
    });
  }

  /**
   * Indicate that post is published.
   *
   * @return \Database\Factories\Blog\PostFactory
   */
  public function published(): PostFactory
  {
    return $this->state(function (array $attributes) {
      return [
        'status'       => 'published',
        'published_at' => now(),
      ];
    });
  }

  /**
   * Indicate that post is rejected.
   *
   * @return \Database\Factories\Blog\PostFactory
   */
  public function rejected(): PostFactory
  {
    return $this->state(function (array $attributes) {
      return [
        'status' => 'rejected',
      ];
    });
  }

  /**
   * Indicate that post is submitted.
   *
   * @return \Database\Factories\Blog\PostFactory
   */
  public function submitted(): PostFactory
  {
    return $this->state(function (array $attributes) {
      return [
        'status' => 'submitted',
      ];
    });
  }
}
