@extends('layouts.app')

@section('content')
<div id="app">
	<header-component></header-component>
	<main class="my-4">
		<router-view></router-view>
	</main>
</div>
<script src="{{ mix('js/dashboard.js') }}"></script>
@endsection