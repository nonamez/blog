<template>
	<div class="form-floating">
		<input :type="type" class="form-control" v-model="returnable" :id="id" :name="name" :placeholder="title">
		<label :for="id">{{ title }}</label>
	</div>
</template>
<script>
import { props, returnable } from './_mixin.js';

export default {
	props: {
		...props,
		
		type: {
			type: String,
			default: 'text'
		}
	},

	setup(props, {emit}) {
		return {
			returnable: returnable(props, emit)
		};
	},
};
</script>