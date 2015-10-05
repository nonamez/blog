<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="HandheldFriendly" content="True">

<title>@section('title') @lang('blog.title') @show</title>

<meta name="csrf-token" content="<?php echo csrf_token();?>">

<meta name="description" content="{{ $meta_description or Lang::get('blog.meta.description') }}"> 
<meta name="keywords" content="{{ $meta_keywords or Lang::get('blog.meta.keywords') }}"> 

<link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/plugins/syntax-highlight/styles.css') }}">

<link rel="stylesheet" href="{{ asset('/assets/blog/app.css') }}">

@yield('custom_styles')

<script>var root_url = '{{ URL::to('/') }}'</script>

<link rel="canonical" href="{{ URL::current() }}">