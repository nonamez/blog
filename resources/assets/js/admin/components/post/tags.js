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
			this.tags.push(Vue.util.extend({}, this.tag))

			this.tag.name = ''
			this.tag.slug = ''
		}
	},

	created: function() {
		console.log('tags created')
	},
	mounted: function() {
		console.log('tags mounted')
	}
}