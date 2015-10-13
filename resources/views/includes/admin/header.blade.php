<header class="clearfix">
	<nav>
		<ul class="nav nav-pills pull-right">
			<li class="dropdown{{ $menu == 'posts' ? ' active' : ''}}" role="presentation">
				<a aria-expanded="false" role="button" href="#" data-toggle="dropdown" class="dropdown-toggle">
					Posts <span class="caret"></span>
				</a>
				<ul role="menu" class="dropdown-menu">
					<li>
						<a href="{{ route('admin_posts') }}">All</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="{{ route('admin_post_create') }}">Create</a>
					</li>
				</ul>
			</li>
			<li role="presentation"{!! $menu == 'files' ? ' class="active"' : '' !!}>
				<a href="{{ route('admin_files') }}">Files</a>
			</li>
			<li role="presentation">
				<a href="{{ route('logout') }}">Log Out</a>
			</li>
		</ul>
	</nav>
	<h3 class="text-muted">Admin Panel</h3>
</header>