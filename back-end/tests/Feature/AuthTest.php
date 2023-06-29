<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;
use App\Models\User;

class AuthTest extends TestCase
{
    //use RefreshDatabase;

    private $faker;
    private $email;
    private $pass;
    private $name;

    public function setUp(): void
    {
        parent::setUp();

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
        'email' => $this->faker->email,
        'password' => $this->pass,
        ]);
        $this->assertEquals(401, $response->status());
    }

  public function test_invalid_password()
  {
    User::create([
      'name' => $this->name,
      'email' => $this->email,
      'password' => bcrypt($this->pass),
    ]);

    $response = $this->post('/api/login',[
      'email' => $this->email,
      'password' => $this->faker->password, //using two different passwords
    ]);
    $this->assertEquals(401, $response->status());
  }

  public function test_invalid_email()
  {
    $response = $this->post('/api/register',[
      'name' => $this->name,
      'email' => 'invalid email',
      'password' => $this->pass,
    ]);
    $this->assertEquals(400, $response->status());
  }
}
