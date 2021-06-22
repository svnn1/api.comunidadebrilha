<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CoverResource
 *
 * @package App\Http\Resources\Blog
 */
class CoverResource extends JsonResource
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
      'id'  => $this->id,
      'url' => asset("storage/{$this->url}"),
    ];
  }
}
