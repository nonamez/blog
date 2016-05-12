<?php

namespace App\Http\Requests\Admin\Portfolio;

use App\Http\Requests\Request;

class WorkRequest extends Request
{
	public function authorize()
	{
		return TRUE;
	}

	public function rules()
	{
		return [
			'title' => 'required',
			'description' => 'required',
			'files' => 'array'
		];
	}
}
