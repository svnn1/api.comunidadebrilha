<?php

namespace App\Http\Resources\Admin\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PostResource
 *
 * @package App\Http\Resources\Admin\Blog
 */
class PostResource extends JsonResource
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
      'id'      => $this->id,
      'title'   => $this->title,
      'summary' => $this->summary,
      'content' => $this->content,
      'author'  => new PostAuthorResource($this->whenLoaded('author')),
      'cover'   => new CoverResource($this->whenLoaded('cover')),
      'tags'    => PostTagResource::collection($this->whenLoaded('tags')),
      'links'   => [
        'self' => route('admin.blog.post.show', $this->slug),
      ],
    ];
  }
}
