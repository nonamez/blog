import { debounce } from 'lodash';

export default {
	props: ['default', 'type'],

	computed: {
		returnable: {
			get() {
				return this.default;
			},

			set: debounce(function(value) {
				this.$emit('returnable', value);
			}, 500)
		}
	}
};