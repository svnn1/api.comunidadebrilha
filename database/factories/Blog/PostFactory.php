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
}
