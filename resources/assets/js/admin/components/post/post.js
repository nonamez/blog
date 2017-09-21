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
				slug: null
			}
		}
	},
	methods: {
		save: function(event) {
			this.loading = true

			jQuery.post(event.currentTarget.getAttribute('data-route'), this.post, response => {
				this.post = response.post
			}).always(() => {
				this.loading = false
			})
		}
	},
	watch: {
		loading: function(state) {
			if (state) {
				jQuery('#posts-button-save').button('loading')
			} else {
				jQuery('#posts-button-save').button('reset')
			}
		}
	},
	created: function() {
		console.log('post created')
	},
	mounted: function() {
		console.log('post mounted')

		console.log(post)

		if (typeof post != 'undefined') {
			this.post = post
		}
	}
}