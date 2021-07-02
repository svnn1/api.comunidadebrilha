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
      ->count(5)
      ->approved()
      ->has(Image::factory(), 'cover')
      ->has(Tag::factory()->count(1), 'tags')
      ->create();

    Post::factory()
      ->count(2)
      ->archived()
      ->has(Image::factory(), 'cover')
      ->has(Tag::factory()->count(1), 'tags')
      ->create();

    Post::factory()
      ->count(2)
      ->drafted()
      ->has(Image::factory(), 'cover')
      ->has(Tag::factory()->count(1), 'tags')
      ->create();

    Post::factory()
      ->count(2)
      ->rejected()
      ->has(Image::factory(), 'cover')
      ->has(Tag::factory()->count(1), 'tags')
      ->create();

    Post::factory()
      ->count(20)
      ->published()
      ->has(Image::factory(), 'cover')
      ->has(Tag::factory()->count(1), 'tags')
      ->create();

    Post::factory()
      ->count(2)
      ->submitted()
      ->has(Image::factory(), 'cover')
      ->has(Tag::factory()->count(1), 'tags')
      ->create();
  }
}
