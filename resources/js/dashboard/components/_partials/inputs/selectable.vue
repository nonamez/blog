<template>
	<select :id="id" class="form-control" v-model="returnable">
		<option v-for="(opt, index) in options" :value="index" v-bind:key="index">{{ opt }}</option>
	</select>
</template>
<script>
import _MIXIN from './_mixin.js';

export default {
	mixins: [_MIXIN],
	props: ['options']
};
</script>