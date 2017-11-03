module.exports = {
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
				status: 'draft',
				locale: 'en',
				files: []
			}
		}
	},
	methods: {
		save: function(event) {
			this.loading = true

			jQuery.post(event.currentTarget.getAttribute('data-route'), this.post, response => {
				if ('post' in response) {
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
	},
	mounted: function() {
		console.log('post mounted')

		if (typeof post != 'undefined') {
			this.post = post
		}
	}
}