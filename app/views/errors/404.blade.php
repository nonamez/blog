<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
<head>
	<meta charset="utf-8">
	<title>404 Not Found</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/blog/app.css') }}">
</head>
<body>
	<div class="container" style="padding-top:5%">
		<div class="row">
			<div class="col-md-12">
				<main class="content" role="main">
					<div class="container" style="text-align:center">
						<h3>
							Page Not Found
						</h3>
						<h4>The page you are looking for does not exist.</h4>
						<p>
							<a href="javascript: history.back()">Go back to the previous page</a> /
							<a href="{{ URL::to('/' . app()->getLocale() )}}">Go to the index</a>
						</p>
					</div>
				</main>
			</div>
		</div>
	</div>
</body>
</html>