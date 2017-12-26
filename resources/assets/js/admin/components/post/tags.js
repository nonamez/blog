module.exports = {
	props: ['tags'],
	
	data: function () {
		return {
			tag: {
				slug: null,
				name: null
			}
		}
	},
	methods: {
		create: function() {
			if (this.tag.name != null) {
				this.tags.push(Vue.util.extend({}, this.tag))

				this.tag = {
					slug: null,
					name: null
				}
			}
		}
	},

	created: function() {
		console.log('tags created')
	},
	mounted: function() {
		console.log('tags mounted')
	}
}