<?php

namespace App\Http\Requests\Admin\Blog\Post;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateStatusPostRequest
 *
 * @package App\Http\Requests\Admin\Blog\Post
 */
class UpdateStatusPostRequest extends FormRequest
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
      'status' => 'required|string|in:approved,archived,drafted,published,rejected,submitted',
    ];
  }
}
