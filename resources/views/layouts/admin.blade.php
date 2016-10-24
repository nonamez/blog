<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Admin Panel</title>

	<link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/admin/app.css') }}">

	<script>var root_url = '{{ url('/') }}'</script>
</head>
<body>
	<!-- Static navbar -->
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('admin') }}">Dashboard</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li>
						<a href="{{ url('/') }}">Site</a>
					</li>
					<li>
						<a href="{{ route('portfolio') }}">Portfolio</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Posts <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="{{ route('admin.posts.index') }}">Posts</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="{{ route('admin.posts.create') }}">Add new</a></li>
						</ul>
					</li>
					<li role="presentation"{!! $menu == 'files' ? ' class="active"' : '' !!}>
						<a href="{{ route('admin_files') }}">Files</a>
					</li>
					<li class="dropdown{{ $menu == 'portfolio' ? ' active' : ''}}" role="presentation">
						<a aria-expanded="false" role="button" href="#" data-toggle="dropdown" class="dropdown-toggle">
							Portfolio <span class="caret"></span>
						</a>
						<ul role="menu" class="dropdown-menu">
							<li>
								<a href="{{ route('admin_portfolio_works') }}">Works</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ route('admin_portfolio_codes') }}">Codes</a>
							</li>
						</ul>
					</li>
					<li role="presentation">
						<a href="{{ route('logout') }}">Log Out</a>
					</li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>

	@yield('content')

	<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

	@stack('scripts')
</body>
</html>