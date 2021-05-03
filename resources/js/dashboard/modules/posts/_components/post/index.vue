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
				</card>

				<card>
					<template v-slot:header>
						Files
					</template>
					<template v-slot:body>
						<div class="input-group mb-3 px-5">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="input-file">
								<label class="custom-file-label" for="input-file">Choose file</label>
							</div>
							<div class="input-group-append">
								<button class="btn btn-outline-secondary secondary-button-light-border" type="button" @click="uploadFile()">
									<i class="icon-plus-circled"></i>
								</button>
							</div>
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item d-flex justify-content-between" v-for="file in files" v-bind:key="file.id">
								<div>
									{{ file.name }}
								</div>
								<div class="btn-group btn-group-sm" role="group">
									<a :href="file.routes.preview" target="blank" type="button" class="btn btn-outline-secondary">
										<i class="icon-file-image"></i>
									</a>
									<button type="button" class="btn btn-outline-secondary" @click="removeFile(file)">
										<i class="icon-trash"></i>
									</button>
								</div>
							</li>
						</ul>
					</template>
				</card>
			</main>
			<!-- <aside class="col-12 col-lg-4">
				<card>
					<template v-slot:header>
						Publish
					</template>
					<template v-slot:body>
						<form-group title="Date" v-slot="{id}">
							<div class="input-group mb-3">
								<input type="text" class="form-control" :id="id" v-model="date">
								<div class="input-group-append">
									<button class="btn btn-outline-secondary secondary-button-light-border" type="button" @click="setDate(new Date)">
										<i class="icon-arrows-cw"></i>
									</button>
								</div>
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
						<form-group title="Markdown" v-slot="{id}">
							<input type="checkbox" class="form-control" :id="id" v-model="markdown">
						</form-group>
						<div class="my-2 text-center">
							<button class="btn btn-success" @click="save()">
								Save
							</button>
							<a class="btn btn-outline-secondary" v-if="preview_url" :href="preview_url" target="blank">
								Preview
							</a>
						</div>
					</template>
				</card>
			</aside> -->
		</div>
	</div>
</template>
<script>
import { computed } from 'vue';
import { useStore } from 'vuex';
// import { route } from 'helpers';
import { createNamespacedHelpers } from 'vuex-composition-helpers';

const VUEX_MODULE = 'posts/post';

const { useState } = createNamespacedHelpers(VUEX_MODULE); // specific module name

export default {
	setup() {
		const store = useStore();

		const data = {
			tag: {
				name: '',
				slug: '',
			},

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

		const date = computed(() => {
			let d = store.state[VUEX_MODULE].date;

			if (d) {
				d = d.split(' ').shift();
			}

			return d;
		});

		return {
			...data,

			date,

			...useState(['title', 'content', 'slug', 'meta_keywords', 'meta_description', 'tags', 'locale', 'status', 'parent_id']),

			// ...useState({
			// 	post_id: 'id'
			// })
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