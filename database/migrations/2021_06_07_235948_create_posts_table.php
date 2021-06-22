<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('posts', function (Blueprint $table) {
      $table->uuid('id')->unique();
      $table->string('title');
      $table->text('summary')->nullable();
      $table->longText('content');
      $table->enum('status', ['drafted', 'submitted', 'rejected', 'approved', 'published', 'archived'])->default('drafted');
      $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
      $table->string('slug')->index();
      $table->timestamp('published_at')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('posts');
  }
}
