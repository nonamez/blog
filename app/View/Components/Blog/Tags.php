<?php

namespace App\View\Components\Blog;

use Illuminate\View\Component;

use App\Models;

class Tags extends Component
{
    private function getTags()
    {
        $name = 'header-tags-' . app()->getLocale();

        $tags = cache()->rememberForever($name, function() {
            $tags = Models\Blog\Tags\Tag::take(15)->join('blg_translated_posts_tags', function($query) {
                $query->on('blg_translated_posts_tags.tag_id', '=', 'blg_tags.id');
            })->join('blg_post_translated', function($query) {
                $query->on('blg_translated_posts_tags.tag_id', '=', 'blg_post_translated.id');
                
                $query->where('locale', '=', app()->getLocale());
                $query->whereIn('status', ['published', 'hidden']);
            })->selectRaw('`blg_tags`.`id`, `blg_tags`.`slug`, `blg_tags`.`name`, COUNT(`blg_translated_posts_tags`.`tag_id`) as aggregate')->groupByRaw(
                '`blg_translated_posts_tags`.`tag_id`, `blg_tags`.`id`, `blg_tags`.`slug`, `blg_tags`.`name`'
            )->orderByRaw('aggregate DESC')->get();

            return $tags;
        });

        return $tags;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.blog.tags')->with('tags', $this->getTags());
    }
}
