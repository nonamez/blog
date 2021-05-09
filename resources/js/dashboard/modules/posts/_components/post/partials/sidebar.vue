<template>
	<form-group title="Date" v-slot="{id}">
		<div class="input-group mb-3">
			<input type="text" class="form-control" :id="id" v-model="date">
			<button class="btn btn-outline-secondary" type="button" @click="setDate(new Date)">
				<i class="icon-arrows-cw"></i>
			</button>
		</div>
	</form-group>
	<form-group title="Locale" v-slot="{id}">
		<selectable :options="locales" :id="id" @returnable="setLocale($event)" :default="locale" name="locale"></selectable>
	</form-group>
	<form-group title="Status" v-slot="{id}">
		<selectable :options="statuses" :id="id" @returnable="setStatus($event)" :default="status" name="status"></selectable>
	</form-group>
	<form-group title="Parent" v-slot="{id}">
		<enterable @returnable="setParentId($event)" :default="parent_id" :id="id"></enterable>
	</form-group>
	<form-group title="Markdown">
		<div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
			<button type="button" v-bind:class="['btn', (markdown ? 'btn-primary' : 'btn-outline-secondary')]" @click="setMarkdown(true)">Yes</button>
			<button type="button" v-bind:class="['btn', (!markdown ? 'btn-primary' : 'btn-outline-secondary')]" @click="setMarkdown(false)">No</button>
		</div>
	</form-group>
	<div class="my-2 text-center">
		<button class="btn btn-success me-3" @click="save()">
			Save
		</button>
		<a class="btn btn-outline-secondary" v-if="preview_url" :href="preview_url" target="blank">
			Preview
		</a>
	</div>
</template>
<script>
import { computed } from 'vue';
import { useStore } from 'vuex';
import { createNamespacedHelpers } from 'vuex-composition-helpers';

const VUEX_MODULE = 'posts/post';

const { useState, useGetters, useMutations, useActions } = createNamespacedHelpers(VUEX_MODULE);

export default {
	setup() {
		const store = useStore();

		return {
			date: computed(() => store.state?.posts?.post?.date?.split(' ').shift()),

			...useState(['locale', 'status', 'parent_id', 'markdown']),
			...useGetters(['preview_url']),
			...useMutations(['setDate', 'setLocale', 'setStatus', 'setMarkdown']),
			...useActions(['save']),

			locales: {
				en: 'English',
				ru: 'Русский',
				lt: 'Lietuviškai',
			},

			statuses: {
				draft: 'Draft',
				published: 'Published',
				hidden: 'Hidden',
			}
		};
	}
};
</script>