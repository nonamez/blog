<?php

namespace App\Http\Requests\Api\V1\Posts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class SavePostRequest extends FormRequest
{
	public function rules()
	{
		$rules = [
			'date'      => 'date_format:Y-m-d H:i:s',
			'slug'      => ['min:3', 'required', 'unique:blg_post_translated,slug,' . optional($this->route('translatedPost'))->id],
			'title'     => ['required', 'min:5'],
			'locale'    => ['required', 'in:' . implode(',', config('blog.locales'))],
			'status'    => ['required', 'in:draft,published,hidden'],
			'content'   => ['required', 'min:10'],
			'tags'      => 'array',
			'files'     => 'array',
			'markdown'  => ['required', 'boolean'],
			'parent_id' => ['nullable', 'exists:blg_posts,id']
		];

		return $rules;
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'slug' => Str::slug($this->slug)
		]);
	}
}
