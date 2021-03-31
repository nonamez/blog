<template>
	<div class="flex h-screen bg-gray-100 dark:bg-gray-800 font-roboto">
		<component-sidebar></component-sidebar>
		<div class="flex-1 flex flex-col overflow-hidden">
			<component-header></component-header>
			<main class="flex-1 overflow-x-hidden overflow-y-auto">
				<div class="container mx-auto px-6 py-8">
					<div class="text-gray-500 dark:text-gray-300 text-xl">
						<router-view />
					</div>
				</div>
			</main>
		</div>
	</div>
</template>
<script>
import { Header, Sidebar } from 'd-partials';

export default {
	components: {
		'component-header': Header,
		'component-sidebar': Sidebar
	}
};
</script>