<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');
        $response->assertSeeText('Home Page');
        $response->assertSeeText('Laravel App');
    }

    public function testContactPageIsWorkingCorrectly() {
        $response = $this->get('/contact');
        $response->assertSeeText('Contact Page');
    }
}
