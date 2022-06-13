<?php

namespace App\Http\Controllers\Api\V1\Posts;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Resources;
use App\Models;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = Models\Posts\Translated::paginate(100);

        return new Resources\Posts\PostCollection($posts);
    }

    public function find(Models\Posts\Translated $translatedPost)
    {
        $translatedPost->load('tags', 'files');

        return new Resources\Posts\Post($translatedPost);
    }

    public function save(Requests\Api\V1\Posts\SavePostRequest $request, Models\Posts\Translated $translatedPost = NULL)
    {
        

        return $this->find($translatedPost);
    }

    public function delete(Models\Posts\Translated $translatedPost, $all = FALSE)
    {   
        $title = $translatedPost->title;

        if ($all) {
            $translatedPost->parent->delete();
            
            $message = 'The post "%s" and its translations successfully deleted';
        } else {
            $translatedPost->delete();
            
            $message = 'The post "%s" successfully deleted';
        }
        
        return response()->json(['message' => sprintf($message, $title)]);
    }
}
