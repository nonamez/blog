<template>
	<div class="fixed z-30 inset-y-0 left-0 w-60 transition duration-300 transform bg-white dark:bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
		<div class="flex items-center justify-center mt-8">
			<div class="flex items-center">
				<span class="text-gray-800 dark:text-white text-2xl font-semibold">Dashboard</span>
			</div>
		</div>
		<nav class="flex flex-col mt-10 px-4 text-center">
			<router-link :to="{ name: 'posts.index'}" class="py-2 text-sm text-gray-700 dark:text-gray-100 bg-gray-200 dark:bg-gray-800 rounded">Posts</router-link>
			<a href="#" class="mt-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-800 rounded">Invoices</a>
			<a href="#" class="mt-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-800 rounded">Ideas</a>
			<a href="#" class="mt-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-800 rounded">Contacts</a>
			<a href="#" class="mt-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-800 rounded">Settings</a>
		</nav>
	</div>
</template>
<script>

</script>