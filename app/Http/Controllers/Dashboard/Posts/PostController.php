<?php

namespace App\Http\Controllers\Dashboard\Posts;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models;
use App\Http\Resources;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Models\Blog\Posts\Translated::orderBy('date', 'DESC')->paginate(20);

        return new Resources\Blog\Posts\PostCollection($posts);
    }

    public function find(Models\Blog\Posts\Translated $translated_post)
    {
        $translated_post->load('tags', 'files');

        return new Resources\Blog\Posts\Post($translated_post);
    }


    public function save(Request $request, Models\Blog\Posts\Translated $translated_post = NULL)
    {
        $request->merge([
            'slug' => Str::slug($request->slug),
        ]);

        $rules = [
            'date'      => 'date_format:Y-m-d H:i:s',
            'slug'      => ['min:3', 'required', 'unique:blg_post_translated,slug,' . optional($translated_post)->id],
            'title'     => ['required', 'min:5'],
            'locale'    => ['required', 'in:' . implode(',', config('blog.locales'))],
            'status'    => ['required', 'in:draft,published,hidden'],
            'content'   => ['required', 'min:10'],
            'tags'      => 'array',
            'files'     => 'array',
            'markdown'  => ['required', 'boolean'],
            'parent_id' => ['nullable', 'exists:blg_posts,id']
        ];

        $request->validate($rules);

        if ($translated_post == NULL) {
            $translated_post = new Models\Blog\Posts\Translated;
        }

        $translated_post->fill($request->all());

        // Select parent or create new
        $parent_post = Models\Blog\Posts\Post::findOrNew($request->parent_post);

        if ($parent_post->exists == FALSE) {
            $parent_post->user_id = auth()->id();

            $parent_post->save();
        }

        $parent_post->translations()->save($translated_post);

        // ========================= Tags ========================= //

        $tags = [];

        foreach ($request->get('tags', []) as $tag) {
            if (strlen($tag['slug']) == 0) {
                $tag['slug'] = $tag['name'];
            }

            $tag['slug'] = Str::slug($tag['slug']);

            $tag = Models\Blog\Tags\Tag::firstOrCreate([
                'slug' => $tag['slug']
            ], [
                'name' => $tag['name']
            ]);

            $tags[] = $tag->id;
        }

        $translated_post->tags()->sync($tags);

        // ========================= Files ========================= //

        // Here we also could do "UPDATE" by ids for faster performance
        DB::table((new Models\Files\File)->getTable())->whereIn('id', $request->get('files'))->update([
            'fileable_id' => $translated_post->id,
            'fileable_type' => 'posts'
        ]);

        $translated_post->load('files', 'tags');

        return $this->find($translated_post);
    }

    public function delete(Models\Blog\Posts\Translated $translated_post, $all = FALSE)
    {   
        $title = $translated_post->title;

        if ($all) {
            $translated_post->parent->delete();
            
            $message = 'The post "%s" and its translations successfully deleted';
        } else {
            $translated_post->delete();
            
            $message = 'The post "%s" successfully deleted';
        }
        
        return response()->json(['message' => sprintf($message, $title)]);
    }
}
