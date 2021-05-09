<?php

namespace App\Models\Blog\Posts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models;

class Translated extends Model
{
    use HasFactory;

    protected $table = 'blg_post_translated';

    protected $fillable = ['title', 'locale', 'status', 'content', 'meta_keywords', 'meta_description', 'meta_title', 'markdown', 'date', 'slug'];
    protected $dates    = ['date'];

    protected $appends  = ['routes'];

    // ========================= Attributes ========================= //

    public function getRoutesAttribute()
    {
        return (object) [
            'preview' => $this->getUrl(),
            
            'save' => route('dashboard.posts.save', $this->id),
            'find' => route('dashboard.posts.find', $this->id)
        ];  
    }

    // ========================= Scopes ========================= //

    public function scopePermitted($query)
    {
        if (auth()->guest()) {
            $query->whereIn('status', ['published', 'hidden']);
        }

        return $query;
    }

    // ========================= Relations ========================= //

    public function parent()
    {
        return $this->belongsTo(Post::class, 'parent_post_id');
    }

    public function tags()
    {
    	return $this->belongsToMany(Models\Blog\Tags\Tag::class, 'blg_translated_posts_tags', 'post_id' ,'tag_id')->withTimestamps();
    }

    public function files()
    {
        return $this->morphMany(Models\Files\File::class, 'fileable');
    }

    // ========================= Custom Methods ========================= //

    public function getUrl()
    {
        return url(sprintf('/%s/post/%s', $this->locale, $this->slug));
    }
}
