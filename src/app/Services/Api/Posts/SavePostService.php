<?php

namespace App\Services\Api\Posts;

use App\Contracts;

class SavePostService implements Contracts\Service
{
	public function perform(array $data, Models\Posts\Translated $translatedPost = NULL) : Models\Posts\Translated
	{
		if ($translatedPost == NULL) {
            $translatedPost = new Models\Posts\Translated;
        }

        $translatedPost->fill($request->all());

        // Select parent or create new
        $parent_post = Models\Posts\Post::findOrNew($request->parent_post);

        if ($parent_post->exists == FALSE) {
            $parent_post->user_id = auth()->id();

            $parent_post->save();
        }

        $parent_post->translations()->save($translatedPost);

        // ========================= Tags ========================= //

        $this->handleTags();

        // ========================= Files ========================= //

        $this->handleFiles();

        return $translatedPost;
	}

	protected function handleTags(array $data, Models\Posts\Translated $translatedPost) : void
	{
		$tags = [];

        foreach (data_get('tags', $data, []) as $tag) {
            if (strlen($tag['slug']) == 0) {
                $tag['slug'] = $tag['name'];
            }

            $tag['slug'] = Str::slug($tag['slug']);

            $tag = Models\Tags\Tag::firstOrCreate([
                'slug' => $tag['slug']
            ], [
                'name' => $tag['name']
            ]);

            $tags[] = $tag->id;
        }

        $translatedPost->tags()->sync($tags);
	}

	protected function handleFiles(array $data) : void
	{
		// Here we also could do "UPDATE" by ids for faster performance
        DB::table((new Models\Files\File)->getTable())->whereIn('id', $request->get('files'))->update([
            'fileable_id' => $translatedPost->id,
            'fileable_type' => 'posts'
        ]);

        $translatedPost->load('files', 'tags');
	}
}