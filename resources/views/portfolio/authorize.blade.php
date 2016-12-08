@extends('layouts.portfolio')

@section('content')
<div class="text-center">
	<div class="authorize-form">
		<form action="{{ route('portfolio.authenticate.post') }}" method="POST" class="text-left">
			{{ csrf_field() }}
			<div class="main-authorize-form">
				<div class="authorize-group">
					<div class="form-group">
						<input type="password" class="hidden"> <!-- FF fix -->
						<input type="password" class="form-control" name="code" placeholder="Enter Code" autocomplete="off">
					</div>
				</div>
				<button type="submit" class="authorize-button">
					<i class="glyphicon glyphicon-chevron-right"></i>
				</button>
			</div>
			<div class="etc-authorize-form">
				To get the code please <a href="{{ route('about') }}">contact me</a>.
			</div>
		</form>
	</div>
</div>
@endsection