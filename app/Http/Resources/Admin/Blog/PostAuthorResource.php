<?php

namespace App\Http\Resources\Admin\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PostAuthorResource
 *
 * @package App\Http\Resources\Admin\Blog
 */
class PostAuthorResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return array
   */
  public function toArray($request): array
  {
    return [
      'name'  => (string) $this->name,
      'links' => (array) [
        'self' => 'todo',
      ],
    ];
  }
}
