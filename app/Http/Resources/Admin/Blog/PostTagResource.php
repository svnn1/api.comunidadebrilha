<?php

namespace App\Http\Resources\Admin\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PostTagResource
 *
 * @package App\Http\Resources\Admin\Blog
 */
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
        'self' => route('admin.blog.tag.show', $this->id),
      ],
    ];
  }
}
