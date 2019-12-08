<template>
	<textarea v-if="type == 'textarea'" class="form-control" v-model="returnable" :id="id" :name="name"></textarea>
	<input v-else type="text" class="form-control" v-model="returnable" :id="id" :name="name">
</template>
<script>
import _MIXIN from './_mixin.js';

export default {
	mixins: [_MIXIN]
};
</script>