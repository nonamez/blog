<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
	public function authorize()
	{
		return TRUE;
	}

	public function rules()
	{
		$rules = [
			'slug'    => ['min:3'],
			'title'   => ['required', 'min:5'],
			'locale'  => ['required', 'in:' . implode(',', config('app.locales'))],
			'status'  => ['required', 'in:draft,published,hidden'],
			'content' => ['required', 'min:10'],
			'tags'    => ['array', 'min:1'],
			'files'   => 'array',
			'parent_post_id' => 'exists:blg_posts,id'
		];

		if ($this->post_id) {
			$rules['slug'][] = 'unique:blg_translated_posts,slug,' . $this->post_id;
		} else {
			$rules['slug'][] = 'unique:blg_translated_posts';
		}

		return $rules;
	}
}
