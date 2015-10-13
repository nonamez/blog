<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class PostRequest extends Request
{
	public function authorize()
	{
		return TRUE;
	}

	public function rules()
	{
		return [
			'slug'    => ['required', 'unique:blg_translated_posts,id' . $this->get('post_id')],
			'title'   => ['required', 'min:5'],
			'locale'  => ['required', 'in:' . implode(',', config()->get('app.locales'))],
			'status'  => ['required', 'in:draft,published'],
			'content' => ['required', 'min:10'],
			'tags'    => ['array', 'min:1'],
			'files'   => 'array',
			'parent_post' => 'exists:blg_posts,id'
		];
	}
}