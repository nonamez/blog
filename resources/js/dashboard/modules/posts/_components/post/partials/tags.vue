<template>
	<div class="mb-3">
		<div class="input-group mb-3">
			<input type="text" class="form-control" v-model="tag.slug" placeholder="Enter Slug">
			<div class="input-group-append border-right-0">
				<span class="input-group-text">
					<i class="icon-exchange"></i>
				</span>
			</div>
			<input type="text" class="form-control border-left-0" v-model="tag.name" placeholder="Enter Name">
			<div class="input-group-append">
				<button class="btn btn-outline-secondary secondary-button-light-border" type="button" @click="addTag()">
					<i class="icon-plus-circled"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="btn-group btn-group-sm mr-2 mb-2" role="group" v-for="(tag, index) in tags" v-bind:key="tag.id">
		<a :href="getTagRoute(tag.slug)" class="btn btn-outline-primary" target="blank">{{ tag.name }}</a>
		<button type="button" class="btn btn-danger" @click="removeTag(index)">
			<i class="icon-trash"></i>
		</button>
	</div>
</template>
<script>
export default {
	setup() {
		return {
			tags: [],
			tag: {
				name: '',
				slug: '',
			}
		};
	}
};
</script>