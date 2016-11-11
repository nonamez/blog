<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Helpers;
use App\Models\Portfolio;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Portfolio\WorkRequest;


class WorkController extends Controller
{
	public function index()
	{
		$works = Portfolio\Work::with('images')->get();

		return view('admin.portfolio.works', compact('works'));
	}

	public function work($work_id = FALSE)
	{
		$work  = $work_id ? Portfolio\Work::with('images')->find($work_id) : NULL;
		$route = $work_id ? route('admin_portfolio_update_work', $work_id) : route('admin_portfolio_store_work');

		return view('admin.portfolio.work', compact('work', 'route'));
	}

	public function store(WorkRequest $request)
	{
		$work = Portfolio\Work::create($request->except('_token'));

		Helpers\Admin\File::attach($request->get('images', []), $work->id, 'portfolio');

		return redirect()->route('admin_portfolio_edit_work', $work->id);
	}

	public function update(WorkRequest $request, $work_id)
	{
		$work = Portfolio\Work::find($work_id);

		if ($work) {
			$work->update($request->except('_token'));

			Helpers\Admin\File::attach($request->get('images', []), $work->id, 'portfolio');
		}

		return redirect()->back();
	}

	public function delete($work_id)
	{
		$work = Portfolio\Work::with('images')->find($work_id);

		if (is_null($work) == FALSE) {
			Helpers\Admin\File::deleteAll($work->images, 'portfolio');

			$work->delete();
		}

		return redirect()->back();
	}
}