<template>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label" :for="id">{{ title }}</label>
		<div class="col-sm-8">
			<slot :id="id"></slot>
		</div>
	</div>
</template>
<script>
export default {
	props: ['title'],

	computed: {
		id() {
			return (~~(Math.random()*1e8)).toString(16);
		}
	}
};
</script>