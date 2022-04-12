<?php

namespace App\Http\Resources\Blog\Posts;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_post_id' => $this->parent_post_id,

            'locale' => $this->locale,
            'status' => $this->status,

            'date' => $this->date->format('Y-m-d H:i:s'),

            'slug'   => $this->slug,

            'title'   => $this->title,
            'content' => $this->content,

            'meta_description' => $this->meta_description,
            'meta_keywords'    => $this->meta_keywords,

            'markdown' => $this->markdown,

            'tags'   => Resources\Blog\Tags\Tag::collection($this->tags),
            'routes' => $this->routes,

            'files' => Resources\Files\File::collection($this->files),

            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
