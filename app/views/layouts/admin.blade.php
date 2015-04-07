<!DOCTYPE html>
<html lang="en">
<head>
	@include('includes.admin.head')
</head>
<body>
	<div class="container">
		@include('includes.admin.header')
		<section class="row" id="content">
			@yield('content')
		</section>
		@include('includes.admin.footer')
	</div>
</body>
</html>