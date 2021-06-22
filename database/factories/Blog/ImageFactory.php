<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Image::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'url' => UploadedFile::fake()->create('cover.png'),
    ];
  }
}
