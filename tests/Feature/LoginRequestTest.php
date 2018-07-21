<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\CreatesUserToken;

class LoginRequestTest extends TestCase
{
    use DatabaseMigrations;
    use CreatesUserToken;

    public function setUp()
    {
        parent::setUp();

        $this->token('johndavedecano@gmail.com', 'password');
    }

    public function testLoginFailed()
    {
        $response = $this->post('/api/v1/auth/login', [
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertStatus(403);
    }

    public function testLoginValidationFailed()
    {
        $response = $this->post('/api/v1/auth/login', [
            'email' => '',
            'password' => ''
        ]);

        $response->assertStatus(422);
    }

    public function testLoginSuccess()
    {
        $response = $this->post('/api/v1/auth/login', [
            'email' => 'johndavedecano@gmail.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }
}
