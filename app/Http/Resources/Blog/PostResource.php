<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

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
      'id'           => $this->id,
      'title'        => $this->title,
      'summary'      => $this->summary,
      'content'      => $this->content,
      'cover'        => [
        'id'  => $this->cover->id,
        'url' => asset("storage/{$this->cover->url}"),
      ],
      'author'       => [
        'id'    => $this->author->id,
        'name'  => $this->author->name,
        'links' => [
          'self' => route('blog.author.show', $this->author->id),
        ],
      ],
      'tags'         => PostTagResource::collection($this->whenLoaded('tags')),
      'published_at' => $this->published_at,
      'links'        => [
        'self' => route('blog.post.show', $this->slug),
      ],
    ];
  }
}
