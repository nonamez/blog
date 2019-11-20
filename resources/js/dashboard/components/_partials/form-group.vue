<template>
	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ title }}</label>
		<div class="col-sm-9">
			<slot></slot>
		</div>
	</div>
</template>
<script>
export default {
	props: ['title']
};
</script>