<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

class PostTagResource extends JsonResource
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
      'id'    => (string) $this->id,
      'name'  => (string) $this->name,
      'links' => [
        'self' => route('blog.tag.show', $this->id),
      ],
    ];
  }
}
