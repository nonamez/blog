<template>
	<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
		<div class="container">
			<a class="navbar-brand" :href="routes.dashboard">
				Dashboard
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a :href="routes.index" target="blank" class="nav-link">Blog</a>
					</li>
				</ul>

				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown" v-bind:class="{active: route_active.startsWith('posts')}">
						<a class="nav-link dropdown-toggle" href="#" id="posts-menu-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Posts
						</a>
						<div class="dropdown-menu" aria-labelledby="posts-menu-dropdown">
							<router-link :to="{ name: 'posts.index' }" class="dropdown-item">Posts</router-link>
							<div class="dropdown-divider"></div>
							<router-link :to="{ name: 'posts.show' }" class="dropdown-item">Create</router-link>
						</div>
					</li>
					<li class="nav-item" v-bind:class="{active: route_active.startsWith('files')}">
						<router-link :to="{ name: 'files.index' }" class="nav-link">Files</router-link>
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
import { route } from 'helpers';

export default {
	data() {
		return {
			route_active: this.$router.currentRoute ? this.$router.currentRoute.name : '',

			routes: {
				index: _BASE_URL,
				dashboard: route('dashboard.index'),
			}
		};
	},

	watch: {
		$route(to) {
			this.route_active = to.name;
		}
	},

	methods: {
		logout() {
			axios.post(route('logout')).then(() => {
				window.location.replace(route('login'));
			});
		}
	}
};
</script>