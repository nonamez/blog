<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BlogLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('layouts.blog');
    }

    private function getTopLinks($value='')
    {
        mb_internal_encoding('UTF-8');

        $top_links = [
            [
                'segment' => NULL,
                'url'  => url(app()->getLocale()),
                'char' => mb_substr(trans('blog.header.menu.home'), 0, 1),
                'text' => mb_substr(trans('blog.header.menu.home'), 1),
            ],

            [
                'segment' => 'about',
                'url'  => route('blog.about', app()->getLocale()),
                'char' => mb_substr(trans('blog.header.menu.about'), 0, 1),
                'text' => mb_substr(trans('blog.header.menu.about'), 1),
            ],
        ];

        $view->with('top_links', $top_links);
        $view->with('top_links_segment', request()->segment(2));
    }
}
