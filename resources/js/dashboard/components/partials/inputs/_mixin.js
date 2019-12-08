import { debounce, getId } from 'helpers';

export default {
	props: {
		default: null, 
		type: null, 
		id: {
			type: String,
			default: getId()
		},
		name: {
			type: String,
			default: null
		}
	},

	computed: {
		returnable: {
			get() {
				return this.default;
			},

			set(value) {
				this.debounced(value);
			}
		}
	},

	created() {
		this.debounced = debounce((value) => {		
			this.$emit('returnable', value);
		}, 500, this.id);
	}
};