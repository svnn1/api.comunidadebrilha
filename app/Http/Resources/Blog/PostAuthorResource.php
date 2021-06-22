<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PostAuthorResource
 *
 * @package App\Http\Resources\Blog
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
