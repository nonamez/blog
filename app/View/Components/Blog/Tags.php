<?php

namespace App\View\Components\Blog;

use Illuminate\View\Component;

use App\Models;

class Tags extends Component
{
    public $tags;

    function __construct($tags = NULL) {
        $this->tags = $tags == NULL ? $this->getTags() : $tags;
    }

    private function getTags()
    {
        $name = 'header-tags-' . app()->getLocale();

        $tags = cache()->rememberForever($name, function() {
            $tags = Models\Blog\Tags\Tag::take(15)->withCount(['posts' => function($query) {
                $query->where('locale', '=', app()->getLocale());
                $query->whereIn('status', ['published', 'hidden']);
            }])->orderBy('posts_count', 'desc')->get();

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
        return view('components.blog.tags');
    }
}
