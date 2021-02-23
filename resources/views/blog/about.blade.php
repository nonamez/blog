<x-blog-layout>
	<main class="content" role="main">
		<div class="container" id="about">
			<p>
				@lang('blog.about.iam')
			</p>
			<p>@lang('blog.about.contact', ['img' => sprintf('<img style="vertical-align:-1px" src="%s" alt="Email address">', asset('images/email.png')), 'telegram' => '<a href="https://t.me/kotoffzky">https://t.me/kotoffzky</a>'])
			</p>
			<p>
				<em>P.S. @lang('blog.about.ps')</em>
			</p>
		</div>
	</main>
</x-blog-layout>
