<template>
	<div class="container">
		<div class="row">
			<main class="col-12 col-lg-8">
				<card>
					<template v-slot:header>
						General
					</template>
					<template v-slot:body>
						<form-group title="Title" v-slot="{id}">
							<enterable @returnable="setTitle($event)" :default="title" name="title" :id="id"></enterable>
						</form-group>
						<form-group title="Content" v-slot="{id}">
							<enterable @returnable="setContent($event)" :default="content" name="content" type="textarea" :id="id"></enterable>
						</form-group>
						<form-group title="Slug" v-slot="{id}">
							<enterable @returnable="setSlug($event)" :default="slug" name="slug" :id="id"></enterable>
						</form-group>
					</template>
				</card>

				<card>
					<template v-slot:header>
						Meta
					</template>
					<template v-slot:body>
						<form-group title="Keywords" v-slot="{id}">
							<enterable @returnable="setMetaKeywords($event)" :default="meta_keywords" name="meta_keywords" :id="id"></enterable>
						</form-group>
						<form-group title="Description" v-slot="{id}">
							<enterable @returnable="setMetaDescription($event)" :default="meta_description" type="textarea" name="meta_description" :id="id"></enterable>
						</form-group>
					</template>
				</card>

				<card>
					<template v-slot:header>
						Tags
					</template>
					<template v-slot:body>
						<tags></tags>
					</template>
				</card>

				<card>
					<template v-slot:header>
						Files
					</template>
					<template v-slot:body>
						<files></files>
					</template>
				</card>
			</main>
			<aside class="col-12 col-lg-4">
				<card>
					<template v-slot:header>
						Publish
					</template>
					<template v-slot:body>
						<sidebar></sidebar>
					</template>
				</card>
			</aside>
		</div>
	</div>
</template>
<script>
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

import { createNamespacedHelpers } from 'vuex-composition-helpers';

const VUEX_MODULE = 'posts/post';

const { useState, useMutations } = createNamespacedHelpers(VUEX_MODULE);

export default {
	components: {
		tags: require('./partials/tags.vue').default,
		files: require('./partials/files.vue').default,
		sidebar: require('./partials/sidebar.vue').default
	},

	setup() {
		const store = useStore();
		const route = useRoute();

		if (route.params.id) {
			store.dispatch(`${VUEX_MODULE}/find`, route.params.id);
		}
		
		return {
			...useState(['title', 'content', 'slug', 'meta_keywords', 'meta_description', 'locale', 'status', 'parent_id']),
			...useMutations(['setTitle', 'setContent', 'setMetaKeywords', 'setMetaDescription', 'setLocale', 'setStatus', 'setParentId', 'setSlug'])
		};
	},

	beforeRouteUpdate() {
		this.$store.commit(`${VUEX_MODULE}/_reset`);
	},

	beforeRouteLeave() {
		this.$store.commit(`${VUEX_MODULE}/_reset`);
	}
};
</script>