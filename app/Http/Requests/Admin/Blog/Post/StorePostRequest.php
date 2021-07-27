<?php

namespace App\Http\Requests\Admin\Blog\Post;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StorePostRequest
 *
 * @package App\Http\Requests\Admin\Blog
 */
class StorePostRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'title'   => 'string|min:2',
      'summary' => 'string|nullable',
      'content' => 'string',
      'tags'    => 'array',
      'cover'   => 'image',
    ];
  }
}
