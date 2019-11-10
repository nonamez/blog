<template>
	<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
		<div class="container">
			<a class="navbar-brand" href="/">
				/home/NoNameZ
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">

				</ul>

				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Posts
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<router-link :to="{ name: 'posts.index' }" class="dropdown-item">Posts</router-link>
							<div class="dropdown-divider"></div>
							<router-link :to="{ name: 'posts.show' }" class="dropdown-item">Create</router-link>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#" @click.prevent="logout()">Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</template>
<script>
import route from 'helpers/route';

export default {
	methods: {
		logout() {
			axios.post(route('logout')).then(() => {
				window.location.replace(route('login'));
			});
		}
	}
};
</script>