<?php

namespace App\Exceptions;

use Redirect;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		HttpException::class,
		ModelNotFoundException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($e instanceof ModelNotFoundException) {
			$e = new NotFoundHttpException($e->getMessage(), $e);
		}

		if ($e instanceof \Illuminate\Database\QueryException) {
			if (strpos($e->getMessage(), 'blg_translated_posts_post_id_locale_unique') !== FALSE)
				$message = 'Locale already exists';
				
			if (strpos($e->getMessage(), 'blg_translated_posts_slug_unique') !== FALSE)
				$message = 'Slug already exists';
			
			if (isset($message))
				return Redirect::back()->withInput()->withErrors($message);
		}

		return parent::render($request, $e);
	}
}
