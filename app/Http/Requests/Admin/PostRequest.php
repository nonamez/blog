<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
	public function authorize()
	{
		return TRUE;
	}

	public function rules()
	{
		return [
			'slug'    => ['unique:blg_translated_posts,id' . $this->get('post_id'), 'min:3'],
			'title'   => ['required', 'min:5'],
			'locale'  => ['required', 'in:' . implode(',', config('app.locales'))],
			'status'  => ['required', 'in:draft,published,hidden'],
			'content' => ['required', 'min:10'],
			'tags'    => ['array', 'min:1'],
			'files'   => 'array',
			'parent_post' => 'exists:blg_posts,id'
		];
	}
}
