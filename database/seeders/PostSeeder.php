<?php

namespace Database\Seeders;

use App\Models\Blog\Tag;
use App\Models\Blog\Post;
use App\Models\Blog\Image;
use Illuminate\Database\Seeder;

/**
 * Class PostSeeder
 *
 * @package Database\Seeders
 */
class PostSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Post::factory()
      ->count(30)
      ->has(Image::factory(), 'cover')
      ->has(Tag::factory()->count(5), 'tags')
      ->create();
  }
}
