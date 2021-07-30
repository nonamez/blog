<template>
	<div class="form-floating">
		<input type="text" class="form-control" v-model="returnable" :id="id" :name="name" :placeholder="title">
		<label :for="id">{{ title }}</label>
	</div>
</template>
<script>
import { props, returnable } from './_mixin.js';

export default {
	props,

	setup(props, {emit}) {
		return {
			returnable: returnable(props, emit)
		};
	},
};
</script>