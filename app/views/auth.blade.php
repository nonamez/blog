<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			Authorization
		</title>
		<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div id="wrap">
			<div class="container">
				<div class="row" style="margin-top:12%">
					<div class="col-md-4 col-md-offset-4">
						@include('includes.notifications')
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Sign In</h3>
							</div>
							<div class="panel-body">
								{{ Form::open(['route' => 'auth_path', 'class' => 'form-horizontal']) }}
									<div class="form-group">
										<label class="col-sm-4 control-label">Email</label>
										<div class="col-sm-8">
											<input type="email" name="email" class="form-control" placeholder="Enter Email">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label">Password</label>
										<div class="col-sm-8">
											<input type="password" name="password" class="form-control" placeholder="Enter Password">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-4 col-sm-10">
										<button type="submit" class="btn btn-default">Login</button>
									</div>
								{{ Form::close() }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
