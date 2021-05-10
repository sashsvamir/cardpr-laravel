<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{

    public function test_example(): void
    {
        $response = $this->get('/api/login');

        $response->assertStatus(200);
    }
}
