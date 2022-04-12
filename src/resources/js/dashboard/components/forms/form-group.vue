<template>
	<div class="row mb-3">
		<label class="col-sm-4 col-form-label" :for="id">{{ title }}</label>
		<div class="col-sm-8">
			<slot :id="id"></slot>
		</div>
	</div>
</template>
<script>
import { getId } from 'helpers';

export default {
	props: ['title'],

	setup() {
		return {
			id: getId()
		};
	}
};
</script>