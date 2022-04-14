<?php

namespace Tests\Feature\Blog\Posts;

use App\Models;

use Tests\TestCase;

class PostControllerTest extends TestCase
{
    public function testRedirectToLang()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/en');
    }

    public function testBlogPostsFetch()
    {
        $posts = Models\Blog\Posts\Post::factory(10)->hasTranslations()->create();

        $response = $this->followingRedirects()->get('/');

        $response->assertStatus(200);
        
        $response->assertSee('<article class="post-short flex flex-wrap">', FALSE);
    }
}
