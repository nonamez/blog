<template>
	<div class="mb-3">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Enter Slug" v-model="tag.slug">
			<span class="input-group-text">
				<i class="icon-exchange"></i>
			</span>
			<input type="text" class="form-control" placeholder="Enter Name" v-model="tag.name">
			<button class="btn btn-outline-secondary" type="button" @click="addTag()">
				<i class="icon-plus-circled"></i>
			</button>
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
import { route } from 'helpers';
import { useStore } from 'vuex';
import { createNamespacedHelpers } from 'vuex-composition-helpers';

const VUEX_MODULE = 'posts/post';

const { useState, useMutations } = createNamespacedHelpers(VUEX_MODULE);

export default {
	setup() {
		const store = useStore();

		return {
			...useState(['tags', 'locale']),
			...useMutations(['removeTag']),

			tag: {
				name: '',
				slug: '',
			},

			getTagRoute(slug) {
				return route('blog.posts.tag', this.locale, slug);
			},

			addTag() {
				if (this.tag.name.length == 0) {
					alert('Tag name can\'t be empty');

					return;
				}

				store.commit(`${VUEX_MODULE}/addTag`, {
					name: this.tag.name,
					slug: this.tag.slug.length == 0 ? this.tag.name : this.tag.slug
				});

				this.tag.name = '';
				this.tag.slug = '';
			},
		};
	}
};
</script>