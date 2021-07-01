<?php

namespace App\Http\Requests\Admin\Blog\Post;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdatePostCoverRequest
 *
 * @package App\Http\Requests\Admin\Blog\Post
 */
class UpdatePostCoverRequest extends FormRequest
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
      'cover' => 'required|image|mimes:jpg,jpeg,png,svg',
    ];
  }
}
