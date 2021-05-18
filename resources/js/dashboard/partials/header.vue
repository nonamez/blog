<template>
	<header class="mb-3 border-bottom">
		<nav class="navbar navbar-expand-sm navbar-light bg-light" aria-label="Third navbar example">
			<div class="container-fluid">
				<a class="navbar-brand" :href="routes.dashboard">Dashboard</a>
				<button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#header-navbar-expand" aria-controls="header-navbar-expand" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="navbar-collapse collapse" id="header-navbar-expand">
					<ul class="navbar-nav me-auto mb-2 mb-sm-0">
						<li class="nav-item">
							<a class="nav-link" aria-current="page" :href="routes.index">Blog</a>
						</li>
					</ul>
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" v-bind:class="{active: currentRouteName.startsWith('posts')}" href="#" id="header-dropdown-posts" data-bs-toggle="dropdown" aria-expanded="false">Posts</a>
							<ul class="dropdown-menu" aria-labelledby="header-dropdown-posts">
								<router-link :to="{ name: 'posts.index' }" class="dropdown-item">Posts</router-link>
								<div class="dropdown-divider"></div>
								<router-link :to="{ name: 'posts.post' }" class="dropdown-item">Create</router-link>
							</ul>
						</li>
						<li class="nav-item">
							<router-link :to="{ name: 'files.index' }" class="nav-link" aria-current="page">Files</router-link>
						</li>
						<li class="nav-item">
							<a class="nav-link text-danger" href="#" @click.prevent="logout()">Logout</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
</template>
<script>
import { route } from 'helpers';
import { useRoute } from 'vue-router';
import { computed, watch } from 'vue';

export default {
	setup() {
		const _route = useRoute();

		watch(() => _route.name, (to) => {
			currentRouteName = to || '';
		});

		let currentRouteName = computed(() => {
			return _route.name || '' ;
		});

		return {
			currentRouteName,

			routes: {
				index: _BASE_URL,
				dashboard: route('dashboard.index'),
			},

			logout() {
				axios.post(route('logout')).then(() => {
					window.location.replace(route('login'));
				});
			}
		};
	}
};
</script>