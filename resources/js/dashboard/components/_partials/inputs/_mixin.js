import { debounce } from 'lodash';

export default {
	props: ['default', 'type', 'id'],

	computed: {
		returnable: {
			get() {
				return this.default;
			},

			set: debounce(function(value) {
				this.$emit('returnable', value);
			}, 500)
		}
	},
};