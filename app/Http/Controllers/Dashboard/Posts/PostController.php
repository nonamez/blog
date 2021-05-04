<?php

namespace App\Http\Controllers\Dashboard\Posts;

use Illuminate\Http\Request;

use App\Models;
use App\Http\Resources;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Models\Blog\Posts\Translated::orderBy('date', 'DESC')->paginate(20);

        return new Resources\Dashboard\Posts\PostCollection($posts);
    }

    public function find(Models\Blog\Posts\Translated $translated_post)
    {
        $translated_post->load('tags', 'files');

        return new Resources\Dashboard\Posts\Post($translated_post);
    }
}
