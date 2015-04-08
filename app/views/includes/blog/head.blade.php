<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="HandheldFriendly" content="True">

<title>@section('title') @lang('blog.title') @show</title>

<meta name="csrf-token" content="<?php echo csrf_token();?>">

<meta name="description" content="{{ $meta_description or Lang::get('blog.meta.description') }}"> 
<meta name="keywords" content="{{ $meta_keywords or Lang::get('blog.meta.keywords') }}"> 

<link rel="stylesheet" type="text/css" href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/assets/blog/app.css') }}">

<link href="{{ asset('/assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

@yield('custom_styles')
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script>var root_url = '{{ URL::to('/') }}'</script>

<link rel="canonical" href="{{ URL::current() }}">