<template>
	<textarea v-if="type == 'textarea'" class="form-control" v-model="returnable" :id="id" :name="name" :placeholder="title"></textarea>
	<input v-else type="text" class="form-control" v-model="returnable" :id="id" :name="name" :placeholder="title">
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