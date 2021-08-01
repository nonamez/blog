<template>
	<div class="form-floating">
		<select class="form-select" :id="id" v-model="returnable" :name="name">
			<option selected="selected" disabled="disabled">Open this select menu</option>
			<option v-for="(opt, index) in options" :value="opt.id ?? index" v-bind:key="index">{{ opt.name ?? opt }}</option>
		</select>
		<label :for="id">{{ title }}</label>
	</div>
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