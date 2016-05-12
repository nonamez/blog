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
			<li class="dropdown{{ $menu == 'portfolio' ? ' active' : ''}}" role="presentation">
				<a aria-expanded="false" role="button" href="#" data-toggle="dropdown" class="dropdown-toggle">
					Portfolio <span class="caret"></span>
				</a>
				<ul role="menu" class="dropdown-menu">
					<li>
						<a href="{{ route('admin_portfolio_works') }}">Works</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="{{ route('admin_portfolio_codes') }}">Codes</a>
					</li>
				</ul>
			</li>
			<li role="presentation">
				<a href="{{ route('logout') }}">Log Out</a>
			</li>
		</ul>
	</nav>
	<h3><a href="{{ route('admin_posts') }}" class="text-muted">Admin Panel</a></h3>
</header>