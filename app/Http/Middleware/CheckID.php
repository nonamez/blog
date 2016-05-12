<?php

namespace App\Http\Middleware;

use App\Models;

use Closure;
use Response;

class CheckID
{
	public function handle($request, Closure $next)
	{
		$route = $request->route();
		
		$parameters = [
			'file_id' => [
				'model'   => Models\File::class,
				'message' => 'File not found'
			],
			'post_id' => [
				'model'   => Models\Blog\TranslatedPost::class,
				'message' => 'Post not found'
			]
		];
		
		foreach ($parameters as $parameter => $data) {
			if ($parameter = $route->getParameter($parameter, FALSE)) {
				$object = $data['model']::find($parameter);

				if (is_null($object)) {
					if ($request->ajax())
						return Response::json(['status' => FALSE, 'message' => $data['message']]);
					else
						return redirect()->back()->withErrors($data['message']);
				}
			}
		}
		
		return $next($request);
	}
}