require('../../bootstrap.js')
require('../../functions.js')

window.Vue = require('vue');

const app = new Vue({
	el: '#app',
	components: {
		'admin-post-tags': require('./tags.js'),
		'admin-post-files': require('./files.js'),
	},
	data: function () {
		return {
			loading: false,

			post: {
				title: null,
				content: null,
				slug: null,
				markdown: 1,
				status: 'draft',
				locale: 'en',
				files: [],
				tags: [],
				routes: [],
			}
		}
	},
	methods: {
		save: function() {
			this.loading = true;

			this.post.markdown = this.post.markdown ? 1 : 0;

			let url = this.post.created_at ? this.post.routes.update : _STORE_ROUTE;

			jQuery.post(url, this.post, response => {

				if ('post' in response) {
					if (this.post.created_at == undefined) {
						window.history.pushState('', '', response.post.routes.edit);
					}

					this.post = response.post;
				}
			}).always(() => {
				this.loading = false;
			})
		},
		setPostDateToNow: function() {
			this.post.date = (new Date).toMysqlFormat();
		}
	},
	watch: {
		loading: function(state) {
			if (state) {
				jQuery('#posts-button-save').button('loading');
			} else {
				jQuery('#posts-button-save').button('reset');
			}
		}
	},
	created: function() {
		console.log('post created')

		jQuery('#app').show()
	},
	mounted: function() {
		console.log('post mounted')

		if (typeof _POST != undefined && _POST) {
			this.post = _POST
		}
	}
});