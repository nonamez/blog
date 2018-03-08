@extends('layouts.blog')
@section('content')
<main class="content" role="main">
	<div class="container" style="font-weight: 300">
		<p style="font-weight: 600">
			@lang('blog.about.iam')
		</p>
		{{-- <p>
			<em>PHP, JavaScript / NodeJS, Python, MySQL / MariaDB, MongoDB, Redis, HTML, CSS, Laravel, Slim PHP, Symfony, Wordpress, jQuery, Vue, Ionic, Socket.IO, Sequelize, Restify, cheerio, nodemon, API, SDK, Parser, Scraper</em>
		</p> --}}
		<p>@lang('blog.about.contact', ['img' => sprintf('<img style="vertical-align:-1px" src="%s" alt="Email address">', asset('images/email.png'))]) <a href="https://t.me/kotoffzky">https://t.me/kotoffzky</a>
		</p>
		<p>
			<em>P.S. @lang('blog.about.ps')</em>
		</p>
	</div>
</main>
@stop