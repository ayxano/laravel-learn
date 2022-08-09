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
        $post = $this->createDummyBlogPost();

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

    public function testStoreFailForFormValidation() :void {
        // Starting session for CSRF token
        Session::start();
        $params = [
            'title' => 'x',
            'content' => 'x',
            '_token' => csrf_token()
        ];
        $response = $this->post('/posts', $params) // sending data to this endpoint
        ->assertStatus(302) // waiting response status code for 302
        ->assertSessionHas('errors'); // also check session has 'errors' key

        $messages = session('errors')->getMessages(); // get error messages from session
        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid() :void {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Check table have record
        $this->assertDatabaseHas('blog_posts', $post->toArray()); // convert DB record to array

        Session::start();
        $params = [
            'title' => 'A new named title',
            'content' => 'Content changed by test',
            '_token' => csrf_token()
        ];

        $response = $this->put("/posts/{$post->id}", $params) // sending data to this endpoint
        ->assertStatus(302) // waiting response status code for 302
        ->assertSessionHas('status'); // also check session has 'status' key

        $this->assertEquals(session('status'), 'Blog post was updated!'); // check 'status' key on session is equal to 'Blog post was updated!'

        $this->followRedirects($response)->assertSeeText('Blog post was updated!')->assertOk(); // make follow redirect, then check response and status code 200

        $this->assertDatabaseHas('blog_posts', [ // also check new data on DB
            'title' => 'A new named title'
        ]);

        $this->assertDatabaseMissing('blog_posts', $post->toArray()); // also check old data is not found on DB
    }

    private function createDummyBlogPost(): BlogPost {
        $post = new BlogPost();
        $post->title = 'New phpunit blog post';
        $post->content = 'Content of the blog post';
        $post->save();
        return $post;
    }
}
