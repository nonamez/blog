<template>
	<div class="form-group row">
		<label for="inputEmail3" class="col-sm-3 col-form-label">email</label>
		<div class="col-sm-9">
			<slot></slot>
		</div>
	</div>
</template>
<script>
export default {
	created() {
		if (this.$route.params.post_id) {
			this.$store.dispatch('posts/find', this.$route.params.post_id);
		}
	}
};
</script>