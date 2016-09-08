<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Portfolio</title>
	<link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/portfolio/styles.css') }}">
	<link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="text-center">
		<h3>Personal Portfolio</h3>
		<div class="authorize-form">
			<form action="{{ route('portfolio_authorize') }}" method="POST" id="forgot-password-form" class="text-left">
				{{ csrf_field() }}
				<div class="main-authorize-form">
					<div class="authorize-group">
						<div class="form-group">
							<input style="display:none" type="password">
							<input type="password" class="form-control" name="code" placeholder="Enter Code" autocomplete="off">
						</div>
					</div>
					<button type="submit" class="authorize-button">
						<i class="glyphicon glyphicon-chevron-right"></i>
					</button>
				</div>
				<div class="etc-authorize-form">
					To get a code please <a href="http://www.google.com/recaptcha/mailhide/d?k=01VTZtgqL7czWrlPjRp-XJAA==&c=5SrSo3TJLPlPgpISyGJ48eJoPcZ4C0NAnUbH_1fhv9w=">contact me</a>.
				</div>
			</form>
		</div>
	</div>
</body>
</html>