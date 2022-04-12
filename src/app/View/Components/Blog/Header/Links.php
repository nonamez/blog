<?php

namespace App\View\Components\Blog\Header;

use Illuminate\View\Component;

class Links extends Component
{
    public $links;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        mb_internal_encoding('UTF-8');
        
        $this->links = [
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
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.blog.header.links');
    }
}
