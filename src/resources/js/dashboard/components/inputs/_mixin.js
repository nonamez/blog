import { getId, debounce } from 'helpers';
import { computed } from 'vue';

const props =  {
	default: null, 
	
	type: null,

	id: {
		type: String,
		default: () => getId()
	},

	name: {
		type: String,
		default: null
	},
	
	title: {
		type: String,
		default: ''
	},
};

const returnable = function(props, emit) {
	let debounced = debounce((value) => {
		emit('returnable', value);
	}, 500);

	return computed({
		get() {
			return props.default;
		},

		set(value) {
			debounced(value);
		}
	});
};

export { props, returnable };