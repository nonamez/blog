@extends('layouts.blog')
@section('content')
<main class="content" role="main">
	<div class="container">
		<p>
			@lang('about.skills.title')
			<ul>
				<li>@lang('about.skills.li_1')</li>
				<li>@lang('about.skills.li_2')</li>
				<li>@lang('about.skills.li_3')</li>
				<li>@lang('about.skills.li_4')</li>
			</ul>
		</p>
		<p>@lang('about.contact', ['img' => asset('/images/email.png')])
		</p>
		<p>
			<em>P.S. @lang('about.ps')</em>
		</p>
	</div>
</main>
@stop