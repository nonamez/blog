<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'file' => ['required', 'mimes:' . implode(',', config()->get('blog.allowed_files'))],
			'type' => ['in:post,portfolio']
		];
	}
}
