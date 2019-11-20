<template>
	<div class="container">
		<div class="row">
			<main class="col-12 col-lg-8">
				<card>
					<template v-slot:header>
						General
					</template>
					<template v-slot:body>
						<form-group title="Title">
							<enterable @returnable="setTitle($event)" :default="title"></enterable>
						</form-group>
						<form-group title="Content">
							<enterable @input="setContent($event)" :default="content" type="textarea"></enterable>
						</form-group>
					</template>
				</card>

				<card>
					<template v-slot:header>
						Meta
					</template>
					<template v-slot:body>
						<form-group title="Keywords">
							<enterable @returnable="setMetaKeywords($event)" :default="meta_keywords"></enterable>
						</form-group>
						<form-group title="Description">
							<enterable @input="setMetaDescription($event)" :default="meta_description" type="textarea"></enterable>
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
										<i class="icon icon-arrows-cw"></i>
									</span>
								</div>
								<input type="text" class="form-control border-left-0" v-model="tag.name" placeholder="Enter Name">
								<div class="input-group-append">
									<button class="btn btn-outline-secondary" type="button" id="tag-button-add" @click="addTag()">
										<i class="icon icon-plus-circled"></i>
									</button>
								</div>
							</div>
						</div>
						<div class="btn-group btn-group-sm mr-2 mb-2" role="group" v-for="(tag, index) in tags" v-bind:key="tag.id">
							<a :href="getTagRoute(tag.slug)" class="btn btn-outline-primary" target="blank">{{ tag.name }}</a>
							<button type="button" class="btn btn-danger" @click="removeTag(index)">
								<i class="icon icon-trash"></i>
							</button>
						</div>
					</template>
				</card>

				<card>
					<template v-slot:header>
						Files
					</template>
					<template v-slot:body>
						<form-group title="title">
							<input type="text" class="form-control">
						</form-group>
					</template>
				</card>
			</main>
			<aside class="col-12 col-lg-4">
				<card>
					<template v-slot:header>
						Publish
					</template>
					<template v-slot:body>
						<form-group title="title">
							<input type="text" class="form-control">
						</form-group>
					</template>
				</card>
			</aside>
		</div>
	</div>
</template>

<style>
	#tag-button-add {
		border-color: #ced4da;
	}
</style>

<script>
import { mapState, mapMutations } from 'vuex';
import { route } from 'helpers';

export default {
	data() {
		return {
			tag: {
				name: '',
				slug: '',
			}
		};
	},

	computed: {
		...mapState('post', ['title', 'content', 'meta_description', 'meta_keywords', 'tags', 'locale'])
	},

	methods: {
		...mapMutations('post', ['setTitle', 'setContent', 'setMetaKeywords', 'setMetaDescription', 'removeTag']),

		getTagRoute(slug) {
			return route('tag', this.locale, slug);
		},

		addTag() {
			this.$store.commit('post/addTag', {
				name: this.tag.name,
				slug: this.tag.slug.length == 0 ? this.tag.name : this.tag.slug
			});

			this.tag.name = '';
			this.tag.slug = '';
		}
	},

	created() {
		if (this.$route.params.post_id) {
			this.$store.dispatch('post/find', this.$route.params.post_id);
		}
	}
};
</script>