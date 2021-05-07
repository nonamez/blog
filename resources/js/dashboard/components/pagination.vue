<template>
	<div class="datatable-footer" v-if="meta">
		<div class="dataTables_info" role="status" aria-live="polite">Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }} entries</div>
		<div class="dataTables_paginate paging_simple_numbers">
			<a v-bind:class="[{disabled: !previous}, 'paginate_button', 'previous']" data-dt-idx="0" tabindex="0" :disabled="!previous" @click.prevent="load(previous)">←</a>
			<span>
				<a class="paginate_button" tabindex="0" v-if="previous" @click.prevent="load(previous)">{{ previous }}</a>
				<a class="paginate_button current" tabindex="0">{{ current }}</a>
				<a class="paginate_button" tabindex="0" v-if="next" @click.prevent="load(next)">{{ next }}</a>
			</span>
			<a v-bind:class="[{disabled: !next}, 'paginate_button', 'next']" data-dt-idx="3" tabindex="0" :disabled="!next" @click.prevent="load(next)">→</a>
		</div>
	</div>
</template>
<script>
function initialData() {
	return {
		current_page: null,
		from: null,
		last_page: null,
		per_page: null,
		to: null,
		total: null
	};
}

export default {
	props: {
		meta: {
			type: Object,
			default: initialData
		}
	},

	computed: {
		current() { 
			return this.meta.current_page;
		},

		previous() {
			let prev = this.meta.current_page - 1;

			return prev > 0 ? prev : false;
		},

		next() {
			let next = this.meta.current_page + 1;

			return next <= this.meta.last_page && next > this.current ? next : false;
		}
	},

	methods: {
		load(page) {
			if (!page) {
				return;
			}

			if (this.$router) {
				this.$router.push({
					query: {
						...this.$route.query,
						page
					}
				});
			}

			this.$emit('reload', page);
		}
	}
};
</script>