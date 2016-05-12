<?php

namespace App\Http\Controllers\Portfolio;

use Illuminate\Http\Request;

use View;
use Redirect;

use App\Models\Portfolio;
use App\Http\Controllers\Controller;

class AuthorizeController extends Controller
{
	public function index()
	{
		return View::make('portfolio.authorize');
	}

	public function authorizePortfolio(Request $request)
	{
		$code = Portfolio\Code::where('used', '=', 0)->where(DB::raw('BINARY `code`'), '=', $request->code)->first();

		if (is_null($code) == FALSE) {
			$code->used = 1;

			$code->save();

			$request->session()->put('portfolio', time());

			return Redirect::route('portfolio');
		} else
			return Redirect::back();
	}
}
