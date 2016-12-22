@extends('layouts.portfolio')

@section('content')
<div class="row">
	@foreach($works as $work)
	<div class="col-xs-12 col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				{{ $work->title }}
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6">
						<a href="#" class="thumbnail">
							<img src="{{ $work->getPreviewImage() }}">
						</a>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6">
						{{ $work->description }}
					</div>
				</div>
			</div>
		</div>
	</div>
	@endforeach
</div>
@endsection