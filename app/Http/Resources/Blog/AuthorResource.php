<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AuthorResource
 *
 * @package App\Http\Resources\Blog
 */
class AuthorResource extends JsonResource
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
      'id'    => $this->id,
      'name'  => $this->name,
      'posts' => PostResource::collection($this->whenLoaded('posts', $this->publishedPosts()->get())),
      'links' => [
        'self' => route('blog.author.show', $this->id),
      ],
    ];
  }
}
