<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\CreatesUserToken;

class RegistrationRequestTest extends TestCase
{
    use DatabaseMigrations;
    use CreatesUserToken;

    public function setUp()
    {
        parent::setUp();

        $this->data = [
            'first_name' => 'Dave',
            'last_name' => 'Decano',
            'email' => 'johndavedecano2@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
    }

    public function testRegistrationSuccess()
    {
        $response = $this->post('/api/v1/auth/register', $this->data);

        $response->assertStatus(200);
    }

    public function testRegistrationBadPassword()
    {
        $response = $this->post('/api/v1/auth/register',[
            'first_name' => 'Dave',
            'last_name' => 'Decano',
            'email' => 'johndavedecano2@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'otherpassword'
        ]);

        $response->assertStatus(422);
    }


    public function testRegistrationEmailExists()
    {
        $this->token('johndavedecano2@gmail.com');

        $response = $this->post('/api/v1/auth/register', $this->data);

        $response->assertStatus(422);
    }

    public function testRegistrationValidationFailed()
    {
        $response = $this->post('/api/v1/auth/register', [
            'email' => '',
            'password' => ''
        ]);

        $response->assertStatus(422);
    }
}
