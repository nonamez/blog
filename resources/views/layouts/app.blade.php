<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/font-awesome.min.css') }}">
	<link href="{{ asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet">

	<link href="{{ elixir('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div id="app">
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
					<a class="navbar-brand" href="{{ url('/') }}">
						{{ config('app.name', 'Laravel') }}
					</a>
				</div>

				<div class="collapse navbar-collapse" id="app-navbar-collapse">
					<!-- Left Side Of Navbar -->
					<ul class="nav navbar-nav">
						<ul class="nav navbar-nav">
							<li>
								<a href="{{ url('/') }}">Site</a>
							</li>
							<li>
								<a href="{{ route('portfolio') }}">Portfolio</a>
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
							<a href="{{ url('/logout') }}">Log Out</a>
						</li>
					</ul>
				</li>
				@endif
			</ul>
		</div>
	</div>
</nav>

@yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<script>
	jQuery.ajaxSetup({
		cache: false,
		dataType: 'JSON',
		headers: {'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')}
	})

	jQuery(document).ajaxStart(function() {
		jQuery('.has-error').removeClass('has-error').find('.help-block').text('').addClass('hide')
	})

	jQuery(document).ajaxError(function(event, jqXHR, ajaxSettings, errorThrown) {
		if (jqXHR.status == 422) {
			jQuery.each(jqXHR.responseJSON, function(key, text) {
				var element = jQuery('[name="' + key + '"]')

				// In case of array
				if (element.length == 0) {
					element = jQuery('[name="' + key + '[]"]')
				}


				if (element.length == 0) {
					toastr.error(text)

					return
				}

				element.closest('.form-group').addClass('has-error')

				var help_block = element.parent().find('.help-block')

				if (help_block.length > 0) {
					help_block.text(text).removeClass('hide')
				} else {
					toastr.warning(text)
				}
			})
		} else if (jqXHR.status == 404) {
			toastr.warning('Item not found')
		} else {
			console.log(jqXHR)

			if (jqXHR.hasOwnProperty('responseJSON')) {
				toastr.error(jqXHR.responseJSON.message)
			} else {
				toastr.error('A critical error has occured. Please reload the page and try again')
			}
		}
	})
</script>
@stack('scripts')
</body>
</html>
