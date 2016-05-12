<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use View;
use Redirect;

use App\Helpers;
use App\Models\Portfolio;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Portfolio\WorkRequest;


class PortfolioController extends Controller
{
	public function works()
	{
		$works = Portfolio\Work::with('images')->get();

		return view('admin.portfolio.works', compact('works'));
	}

	public function work($id = FALSE)
	{
		$images = [];

		if ($id)
			$images = [];

		return View::make('admin.portfolio.work', compact('images'));
	}

	public function storeWork(WorkRequest $request)
	{
		$work = Portfolio\Work::create($request->except('_token'));

		Helpers\Admin\File::attach($request->get('images', []), $work->id, 'portfolio');

		return redirect()->route('admin_portfolio_works');
	}

	public function delete($work_id)
	{
		$work = Portfolio\Work::with('images')->find($work_id);

		if (is_null($work) == FALSE) {
			Helpers\Admin\File::delete($work->images, 'portfolio');

			$work->delete();
		}

		return redirect()->back();
	}

	public function codes()
	{
		$codes = Portfolio\Code::all();

		return View::make('admin.portfolio.codes', compact('codes'));
	}

	public function createCode(Request $request)
	{
		$code = new Portfolio\Code;

		$code->title = $request->get('title', NULL);
		$code->code  = str_random(12);

		$code->save();

		return Redirect::back();
	}

	public function deleteCode($code_id)
	{
		Portfolio\Code::destroy($code_id);

		return Redirect::back();
	}
}
