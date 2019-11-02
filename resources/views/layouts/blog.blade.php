<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Patua+One&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="{{ mix('css/blog.css') }}">

	<title>@yield('title') /home/NoNameZ</title>
	
	<meta name="keywords" content="@yield('meta_keywords', trans('blog.meta.keywords'))">
	<meta name="description" content="@yield('meta_description', trans('blog.meta.description'))">

	<meta name="author" content="name @ nonamez.name">

	<link rel="alternate" href="{{ url('/lt') }}" hreflang="lt-LT">
	<link rel="alternate" href="{{ url('/en') }}" hreflang="en-US">
	<link rel="alternate" href="{{ url('/ru') }}" hreflang="ru-RU">

	<link rel="canonical" href="{{ url()->current() }}">

	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
	<header class="container">
		<h1>/home/NoNameZ</h1> 
		<nav class="nav">
			<a class="active" href="#">H<span class="hidden md:inline-block">ome</span></a>
			<a href="#">A<span class="hidden md:inline-block">bout</span></a>
			<a href="#">C<span class="hidden md:inline-block">ontact</span></a>
		</nav>
	</header>

	<main class="container">
		@yield('content')
	</main>

	<footer>
		<div class="container">
			footer
		</div>
	</footer>
</body>
</html>
