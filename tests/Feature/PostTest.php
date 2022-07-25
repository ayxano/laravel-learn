<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $post->content = 'Content of the blog post';;
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
}
