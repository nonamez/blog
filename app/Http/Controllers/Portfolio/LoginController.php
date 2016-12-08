<?php

namespace App\Http\Controllers\Portfolio;

use DB;

use Illuminate\Http\Request;

use App\Models;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index()
	{
		return view('portfolio.authorize');
	}
	
	public function authorizePortfolio(Request $request)
	{
		$code = Models\Portfolio\Code::where('used', '=', 0)->where(DB::raw('BINARY `code`'), '=', $request->code)->first();

		if (is_null($code) == FALSE) {
			$code->used = 1;

			$code->save();

			$request->session()->put('portfolio', time());

			return redirect()->route('portfolio.index');
		} else {
			return redirect()->back();
		}
	}
}
