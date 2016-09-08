<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Admin Panel</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/admin/app.css') }}">

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
				<a class="navbar-brand" href="{{ route('admin_posts') }}">Admin Panel</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li>
						<a href="url('/')">Site</a>
					</li>
					<li>
						<a href="{{ route('portfolio') }}">Portfolio</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li role="presentation"{!! $menu == 'posts' ? ' class="active"' : '' !!}>
						<a href="{{ route('admin_posts') }}">Posts</a>
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

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> 
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>