<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
<head>
	@include('includes.blog.head')
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@include('includes.blog.header')
			</div>
			<div class="col-md-12">
				@yield('content')
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				@include('includes.blog.footer')
			</div>
		</div>
		<a href="#" id="back-to-top" class="back-to-top hidden-xs">
			<i class="fa fa-angle-up"></i>
		</a>
	</div>
	<a href="https://github.com/nonamez/blog">
		<img style="position: absolute; top: 0; right: 0; border: 0;" src="{{ asset('/images/fork_me.png')}}" alt="Fork me on GitHub">
	</a>
	<script src="{{ asset('/assets/blog/app.js')}}"></script>
	@yield('custom_scripts')
	@if(strlen(env('GOOGLE_ANALYTICS')) > 0)
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', '{{ env('GOOGLE_ANALYTICS') }}', 'auto');
	ga('send', 'pageview');
	</script>
	@endif
</body>
</html>