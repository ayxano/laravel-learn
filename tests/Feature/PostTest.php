<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPosts() :void
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No posts');
    }

    public function testSee1BlogPostWhenThereis1() :void {
        // Arrange
        $post = new BlogPost();
        $post->title = 'New phpunit blog post';
        $post->content = 'Content of the blog post';
        $post->save();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('New phpunit blog post');

        // Check table have value
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New phpunit blog post'
        ]);
    }

    // Simulating post request to save data on db
    public function testStoreValid() :void 
    {
        // Starting session for CSRF token
        Session::start();
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters',
            '_token' => csrf_token()
        ];
        $response = $this->post('/posts', $params) // sending data to this endpoint
        ->assertStatus(302) // waiting response status code for 302
        ->assertSessionHas('status'); // also check session has 'status' key

        $this->assertEquals(session('status'), 'Created on DB!'); // check 'status' key on session is equal to 'Created on DB!'

        $this->followRedirects($response)->assertSeeText('Created on DB!'); // make follow redirect, then check response
    }
}
