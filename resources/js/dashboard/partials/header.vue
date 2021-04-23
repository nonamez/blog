<template>
<header class="flex justify-between items-center p-6">
	<div class="flex items-center space-x-4 lg:space-x-0">
		<button class="text-gray-500 dark:text-gray-300 focus:outline-none lg:hidden">
			<svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /> </svg>
		</button>
		<div>
			<h1 class="text-2xl font-medium text-gray-800 dark:text-white">Overview</h1>
		</div>
	</div>
	<div class="flex items-center space-x-4">
		<!-- <button @click="darkMode = !darkMode" class="flex text-gray-600 dark:text-gray-300 focus:outline-none" aria-label="Color Mode">
			<svg x-show="darkMode" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
				<path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" /> </svg>
			<svg x-show="!darkMode" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
				<path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" /> </svg>
		</button>
		<button class="flex text-gray-600 dark:text-gray-300 focus:outline-none">
			<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
				<path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /> </svg>
		</button>
		<button class="flex text-gray-600 dark:text-gray-300 focus:outline-none">
			<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /> </svg>
		</button> -->
		<div x-data="{ dropdownOpen: false }" class="relative">
			<button class="flex items-center space-x-2 relative focus:outline-none">
				<h2 class="text-gray-700 dark:text-gray-300 text-sm hidden sm:block"></h2>
				<img class="h-9 w-9 rounded-full border-2 border-purple-500 object-cover" src="https://images.unsplash.com/photo-1553267751-1c148a7280a1?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="Your avatar">
			</button>
			<!-- <div class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10">
				<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-600 hover:text-white">Profile</a>
				<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-600 hover:text-white">Tickets</a>
				<a href="/login" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-600 hover:text-white">Logout</a>
			</div> -->
		</div>
	</div>
</header>
</template>
<script>
export default {

};
</script>