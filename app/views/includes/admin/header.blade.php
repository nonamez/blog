<header class="clearfix">
	<nav>
		<ul class="nav nav-pills pull-right">
			<li class="dropdown active" role="presentation">
				<a aria-expanded="false" role="button" href="#" data-toggle="dropdown" class="dropdown-toggle">
					Posts <span class="caret"></span>
				</a>
				<ul role="menu" class="dropdown-menu">
					<li><a href="{{ URL::action('Admin\PostController@index') }}">All</a></li>
					<li class="divider"></li>
					<li><a href="{{ URL::action('Admin\PostController@create') }}">Create</a></li>
				</ul>
			</li>
		</ul>
	</nav>
	<h3 class="text-muted">Admin Panel</h3>
</header>