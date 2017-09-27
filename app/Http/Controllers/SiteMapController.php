<?php

namespace App\Http\Controllers;

use App\Models;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteMapController extends Controller
{
    public function index()
	{
		$posts = [
			'en' => Models\Blog\Post\Translated::permitted()->where('locale', '=', 'en')->orderBy('updated_at', 'DESC')->first(),
			'ru' => Models\Blog\Post\Translated::permitted()->where('locale', '=', 'ru')->orderBy('updated_at', 'DESC')->first(),
			'lt' => Models\Blog\Post\Translated::permitted()->where('locale', '=', 'lt')->orderBy('updated_at', 'DESC')->first()
		];

		$posts = array_filter($posts);

		return response()->view('sitemap.index', compact('posts'))->header('Content-Type', 'text/xml');
	}

	public function posts($locale)
	{
		$posts = Models\Blog\Post\Translated::permitted()->where('locale', '=', $locale)->orderBy('updated_at', 'DESC')->get();

		return response()->view('sitemap.posts', compact('posts'))->header('Content-Type', 'text/xml');
	}
}