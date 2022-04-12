<template>
	<select :id="id" class="form-control" v-model="returnable" :name="name">
		<option v-for="(opt, index) in options" :value="index" v-bind:key="index">{{ opt }}</option>
	</select>
</template>
<script>
import { props, returnable } from './_mixin.js';

export default {
	props: {
		options: {
			// type: Array,
			default: function() {
				return [];
			}
		},

		...props
	},

	setup(props, {emit}) {
		return {
			returnable: returnable(props, emit)
		};
	},
};
</script>