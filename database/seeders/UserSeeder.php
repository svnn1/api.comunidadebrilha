<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 *
 * @package Database\Seeders
 */
class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::factory()->create([
      'name'     => 'Silvano Santana',
      'email'    => 'jnkppl@hotmail.com',
      'password' => bcrypt('secret'),
    ]);
  }
}
