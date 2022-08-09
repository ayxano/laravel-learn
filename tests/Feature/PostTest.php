<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase; // it will run migrations for each test ( I mean function )

    public function testNoBlogPosts() :void
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No posts');
    }

    public function testSee1BlogPostWhenThereis1() :void 
    {
        // Arrange
        $post = new BlogPost();
        $post->title = 'New phpunit blog post';
        $post->content = 'Content of the blog post';
        $post->save();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText($post->title);

        // Check table have record (Assert 2)
        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title
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

        $this->followRedirects($response)->assertSeeText('Created on DB!')->assertOk(); // make follow redirect, then check response and status code 200

        $this->assertDatabaseHas('blog_posts', [ // also check data on DB
            'title' => 'Valid title'
        ]);
    }

    public function testStoreFailForCSRFIsNotPresent() :void { // check request is not acceptable without CSRF token
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters',
        ];
        $response = $this->post('/posts', $params) // sending data to this endpoint
        ->assertStatus(419) // waiting response status code for 419
        ;
    }
}
