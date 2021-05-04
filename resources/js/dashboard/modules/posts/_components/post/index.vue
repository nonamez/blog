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
// import { computed } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

// import { route } from 'helpers';
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

		console.log(store);

		store.dispatch(`${VUEX_MODULE}/find`, route.params.id);
		
		return {
			...useState(['title', 'content', 'slug', 'meta_keywords', 'meta_description', 'locale', 'status', 'parent_id']),
			...useMutations(['setTitle', 'setContent', 'setMetaKeywords', 'setMetaDescription', 'setLocale', 'setStatus', 'setParentId', 'setSlug'])
		};
	},

	// computed: {
	// 	...mapState('post', ['title', 'content', 'slug', 'meta_keywords', 'meta_description', 'tags', 'locale', 'status', 'date', 'parent_id']),
		
	// 	...mapState('post', {
	// 		post_id: 'id',
	// 	}),

	// 	...mapGetters('post', ['preview_url']),

	// 	...mapState('files', ['files']),

	// 	// date() {
	// 	// 	let d = this.$store.state.post.date;

	// 	// 	if (d) {
	// 	// 		d = d.split(' ').shift();
	// 	// 	}

	// 	// 	return d;
	// 	// },

	// 	markdown:{
	// 		get() {
	// 			return this.$store.state.post.markdown == 1 ? true : false;
	// 		},
	// 		set(value) {
	// 			this.$store.commit('post/setMarkdown', (value ? 1 : 0));
	// 		}
	// 	}
	// },

	// methods: {
	// 	...mapMutations('post', ['setTitle', 'setContent', 'setMetaKeywords', 'setMetaDescription', 'removeTag', 'setDate', 'setLocale', 'setStatus', 'setParentId', 'setSlug']),
	// 	...mapActions('files', {
	// 		removeFile: 'remove'
	// 	}),

	// 	getTagRoute(slug) {
	// 		return route('blog.posts.tag', this.locale, slug);
	// 	},

	// 	addTag() {
	// 		if (this.tag.name.length == 0) {
	// 			toastr.warning('Tag name can\'t be empty');

	// 			return;
	// 		}

	// 		this.$store.commit('post/addTag', {
	// 			name: this.tag.name,
	// 			slug: this.tag.slug.length == 0 ? this.tag.name : this.tag.slug
	// 		});

	// 		this.tag.name = '';
	// 		this.tag.slug = '';
	// 	},

	// 	uploadFile() {
	// 		this.$store.dispatch('files/upload', document.getElementById('input-file').files[0]).then(status => {
	// 			if (status) {
	// 				document.querySelector('label.custom-file-label').textContent = 'Choose file';
	// 				document.querySelector('#input-file').value = null;
	// 			}
	// 		});
	// 	},

	// 	save() {
	// 		this.$store.dispatch('post/save').then(() => {
	// 			toastr.success('Successfully saved');

	// 			if (this.$route.params.post_id == null) {
	// 				window.history.pushState('page2', 'Title', window.location.href + '/' + this.$store.state.post.id);
	// 			}
	// 		});
	// 	}
	// },

	// beforeRouteUpdate(to, from, next) {
	// 	this.$store.commit('files/reset');
	// 	this.$store.commit('post/reset');

	// 	next();
	// },

	// beforeRouteLeave(to, from, next) {
	// 	this.$store.commit('files/reset');
	// 	this.$store.commit('post/reset');

	// 	next();
	// },

	// created() {
	// 	if (this.$route.params.post_id) {
	// 		this.$store.dispatch('post/find', this.$route.params.post_id);
	// 	} else {
	// 		this.$store.commit('files/reset');
	// 		this.$store.commit('post/reset');
	// 	}

	// 	setTimeout(() => {
	// 		jQuery('#input-file').change(function() {
	// 			let name = this.files[0].name;

	// 			if (name.length > 30) {
	// 				name = '...' +  name.substr(-30);
	// 			}

	// 			document.querySelector('label.custom-file-label').textContent = name;
	// 		});
	// 	});
	// }
};
</script>