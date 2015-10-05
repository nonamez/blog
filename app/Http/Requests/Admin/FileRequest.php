<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class FileRequest extends Request
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'file' => ['required', 'mimes:' . implode(',', config()->get('blog.allowed_files'))]
		];
	}
}
