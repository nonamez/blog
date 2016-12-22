<?php

namespace App\Http\Controllers\Admin\Portfolio;

use Illuminate\Http\Request;

use App\Models;
use App\Http\Controllers\Controller;

class CodeController extends Controller
{
	public function index()
	{
		$codes = Models\Portfolio\Code::get();

		return view('admin.portfolio.codes.index', compact('codes'));
	}

	public function store(Request $request)
	{
		$code = new Models\Portfolio\Code;

		$code->title = $request->get('title', NULL);
		$code->code  = str_random(12);

		$code->save();

		return redirect()->back();
	}

	public function delete($code_id)
	{
		Models\Portfolio\Code::destroy($code_id);

		return redirect()->back();
	}
}