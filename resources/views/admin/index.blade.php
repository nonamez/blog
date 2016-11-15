@extends('layouts.app')
@section('content')
<div class="container">
	@yield('admin.content')
</div>
@stop
@push('scripts')
<script src="{{ elixir('js/admin.js') }}"></script>
@endpush