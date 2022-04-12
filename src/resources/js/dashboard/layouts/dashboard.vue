<template>
	<div>
		<component-header></component-header>
		<main class="my-4">
			<router-view></router-view>
		</main>
	</div>
</template>
<script>
import { Header } from 'partials';

export default {
	components: {
		'component-header': Header,
	},

	created() {
		alert('dashboard created');
	}
};
</script>