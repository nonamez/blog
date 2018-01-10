<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title', 'Dashboard')</title>

	<!-- Styles -->
	{{-- <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/abc/awesome-bootstrap-checkbox.css') }}"> --}}

	<link rel="stylesheet" href="{{ mix('css/admin.css') }}">
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

				<!-- Right Side Of Navbar -->
				<ul class="nav navbar-nav navbar-right">
					<!-- Authentication Links -->
					@if (Auth::guest())
					<li>
						<a href="{{ url('/login') }}">Login</a>
					</li>
					@else
					<li class="dropdown{{ $menu == 'posts' ? ' active' : '' }}">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Posts <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="{{ route('admin.posts.index') }}">Posts</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="{{ route('admin.posts.create') }}">Create Post</a></li>
						</ul>
					</li>
					<li role="presentation"{!! $menu == 'files' ? ' class="active"' : '' !!}>
						<a href="{{ route('admin.files.index') }}">Files</a>
					</li>
					<li role="presentation">
						<a href="{{ url('/logout') }}">Log Out</a>
					</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	
	@yield('content')
	
	@stack('js')
	</body>
</html>
