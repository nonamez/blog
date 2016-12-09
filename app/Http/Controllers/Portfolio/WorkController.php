<?php

namespace App\Http\Controllers\Portfolio;

use Illuminate\Http\Request;

use App\Models;
use App\Http\Controllers\Controller;

class WorkController extends Controller
{
	public function index()
	{

		// dd(getRandomCatImageURL());
		$works = Models\Portfolio\Work::get();

		return view('portfolio.works', compact('works'));
	}
}
