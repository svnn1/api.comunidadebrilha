<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request): array
  {
    return [
      'title'       => $this->title,
      'summary'     => $this->summary,
      'content'     => $this->content,
      'author'      => new PostAuthorResource($this->whenLoaded('author')),
      'cover'       => new CoverResource($this->whenLoaded('cover')),
      'tags'        => PostTagResource::collection($this->whenLoaded('tags')),
      'links'       => [
        'self' => route('blog.post.show', $this->slug),
      ],
    ];
  }
}
