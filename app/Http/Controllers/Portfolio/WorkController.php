<?php

namespace App\Http\Controllers\Portfolio;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Portfolio;
use App\Http\Controllers\Controller;

class WorkController extends Controller
{
	public function index()
	{
		$works = Portfolio\Work::with('images')->get();

		dd($works);
	}
}
