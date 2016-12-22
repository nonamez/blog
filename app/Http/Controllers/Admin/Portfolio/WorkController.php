<?php

namespace App\Http\Controllers\Admin\Portfolio;

use Illuminate\Http\Request;

use App\Models;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Portfolio\WorkRequest;


class WorkController extends Controller
{
	public function index()
	{
		$works = Models\Portfolio\Work::with('images')->get();

		return view('admin.portfolio.works.index', compact('works'));
	}

	public function create()
	{
		return view('admin.portfolio.works.create');
	}

	public function store(WorkRequest $request)
	{
		$work = $this->_save($request);

		return response()->json(['redirect_to' => route('admin.portfolio.works.edit', $work->id)]);
	}

	public function edit($work_id)
	{
		$work = Models\Portfolio\Work::findOrFail($work_id);

		return view('admin.portfolio.works.edit', compact('work'));
	}

	public function update(WorkRequest $request, $work_id)
	{
		$work = Models\Portfolio\Work::findOrFail($work_id);

		$this->_save($request, $work);

		return response()->json();
	}

	public function delete($work_id)
	{
		$work = Models\Portfolio\Work::with('images')->findOrFail($work_id);

		foreach ($work->images as $image) {
			$image->delete();
		}

		$work->delete();

		return redirect()->back();
	}

	public function attachImage(Request $request, $work_id)
	{
		$work  = Models\Portfolio\Work::find($work_id);
		$image = Models\File::find($request->image_id);

		if ($work && $image) {
			$work->images()->save($image);
		}

		return response()->json();
	}

	private function _save(& $request, & $work = FALSE)
	{
		if ($work == FALSE) {
			$work = new Models\Portfolio\Work;
		}

		$work->fill($request->all());

		$work->save();

		// ========================= Files ========================= //

		// Here we also could do "UPDATE" by ids for faster performance
		foreach ($request->get('images', []) as $image_id) {
			$image = Models\File::findOrFail($image_id);

			$work->images()->save($image);
		}

		return $work;
	}
}