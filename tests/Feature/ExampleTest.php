<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The root path forwards visitors to the public introduction screen.
     */
    public function test_the_root_path_redirects_to_the_introduction_page(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/intro');
    }

    /**
     * The introduction screen is the public entry point and must render.
     */
    public function test_the_introduction_page_returns_a_successful_response(): void
    {
        $response = $this->get('/intro');

        $response->assertStatus(200);
    }
}
