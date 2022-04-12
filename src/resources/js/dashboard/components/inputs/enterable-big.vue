<template>
	<textarea class="form-control" v-model="returnable" :id="id" :name="name" :placeholder="title"></textarea>
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