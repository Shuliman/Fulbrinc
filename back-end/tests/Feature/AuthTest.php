<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    //use RefreshDatabase;

    private $user;
    private $faker;
    private $email;
    private $pass;
    private $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->faker = Faker::create();
        $this->email = $this->faker->email;
        $this->pass = $this->faker->password(8,16);
        $this->name = $this->faker->firstName;
    }

    public function test_registration ()
    {
        $response = $this->post('/api/register',[
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->pass,
        ]);
        $this->assertEquals(200,$response->status());

    }
    public function test_authorisation ()
    {
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->pass),
        ]);

        $response = $this->post('/api/login',[
            'email' => $this->email,
            'password' => $this->pass,
        ]);
        $this->assertEquals(200,$response->status());

    }

    public function test_invalid_login()
    {
        $response = $this->post('/api/login',[
        'email' => 'fakeemail@example.com',
        'password' => 'password',
        ]);
        $this->assertEquals(401, $response->status());
    }

    public function test_invalid_password()
    {
        $response = $this->post('/api/login',[
            'email' => $this->user->email,
            'password' => 'wrongpassword', // Используем неверный пароль
        ]);
        $this->assertEquals(401, $response->status());
    }

    public function test_invalid_email()
    {
        $response = $this->post('/api/register',[
            'name' => $this->user->name,
            'email' => 'invalid email',
            'password' => 'password',
        ]);
        $this->assertEquals(400, $response->status());
    }
}
