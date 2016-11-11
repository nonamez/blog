<?php

namespace App\Http\Controllers\Admin\Portfolio;

use Illuminate\Http\Request;

use App\Models\Portfolio\Code;
use App\Http\Controllers\Controller;

class CodeController extends Controller
{
	public function codes()
	{
		$codes = Code::all();

		return view('admin.portfolio.codes', compact('codes'));
	}

	public function createCode(Request $request)
	{
		$code = new Code;

		$code->title = $request->get('title', NULL);
		$code->code  = str_random(12);

		$code->save();

		return redirect()->back();
	}

	public function deleteCode($code_id)
	{
		Code::destroy($code_id);

		return redirect()->back();
	}
}