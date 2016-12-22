<?php

namespace App\Http\Requests\Admin\Portfolio;

use Illuminate\Foundation\Http\FormRequest;

class WorkRequest extends FormRequest
{
	public function authorize()
	{
		return TRUE;
	}

	public function rules()
	{
		return [
			'title'       => 'required',
			'description' => 'required',
			'files'       => 'array'
		];
	}
}
