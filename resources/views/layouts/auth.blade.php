<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name') }}</title>

	<!-- Styles -->

	<link href="{{ mix('css/admin.css') }}" rel="stylesheet">
</head>
<body>
		<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">

				<!-- Collapsed Hamburger -->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<!-- Branding Image -->
				<a class="navbar-brand" href="{{ url('/admin') }}">
					Dashboard
				</a>
			</div>

			<div class="collapse navbar-collapse" id="app-navbar-collapse">
				<!-- Left Side Of Navbar -->
				<ul class="nav navbar-nav">
					<ul class="nav navbar-nav">
						<li>
							<a href="{{ url('/') }}">Blog</a>
						</li>
					</ul>
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')
</body>
</html>