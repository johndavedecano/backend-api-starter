<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\CreatesUserToken;

class ForgotPasswordRequestTest extends TestCase
{
    use DatabaseMigrations;
    use CreatesUserToken;

    public function setUp()
    {
        parent::setUp();

        $this->token('johndavedecano@gmail.com');
    }

    public function testForgotPasswordFails()
    {
        $response = $this->post('/api/v1/auth/forgot', ['email' => 'bad@mail']);

        $response->assertStatus(422);
    }

    public function testForgotPasswordEmailNotExist()
    {
        $response = $this->post('/api/v1/auth/forgot', ['email' => 'bad@mail.com']);

        $response->assertStatus(403);
    }

    public function testForgotPasswordEmailOk()
    {
        $response = $this->post('/api/v1/auth/forgot', ['email' => 'johndavedecano@gmail.com']);

        $response->assertStatus(200);
    }
}
