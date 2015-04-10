<!DOCTYPE html>
<html lang="en">
<head>
	@include('includes.admin.head')
</head>
<body>
	<div class="container">
		@include('includes.admin.header')
		<section class="row" id="content">
			@include('includes.notifications')
			@yield('content')
		</section>
		@include('includes.admin.footer')
	</div>
	<script src="{{ asset('/assets/plugins/jquery/jquery-2.1.3.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>