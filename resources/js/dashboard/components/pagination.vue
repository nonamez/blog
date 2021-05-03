<template>
	<div class="text-center">
		<button class="btn btn-outline-dark" @click="load(data.prev_page_url)" :disabled="! data.prev_page_url">Previous</button>
		<span class="mx-3 font-weight-bolder">Page {{ data.current_page }} of {{ data.last_page }}</span>
		<button class="btn btn-outline-dark" @click="load(data.next_page_url)" :disabled="! data.next_page_url">Next</button>
	</div>
</template>
<script>
import { getURLParameterByName } from 'helpers';

function initialData() {
	return {
		prev_page_url: false,
		next_page_url: false,
		current_page: 1,
		last_page: 1
	};
}

export default {
	props: {
		data: {
			type: Object,
			default: initialData
		}
	},

	methods: {
		load(url) {
			this.$emit('reload', url);

			if (this.$router) {
				this.$router.push({
					query: {
						...this.$route.query, page: getURLParameterByName('page', url)
					}
				});
			}
		}
	}
};
</script>