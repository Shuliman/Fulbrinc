<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserSettingsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $password;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->password = $this->faker->password(8,16);
        $this->user = User::factory()->create([
            'password' => bcrypt($this->password),
        ]);
    }

    /** @test */
    public function it_can_retrieve_user_settings()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->getJson(route('settings.index'));

        $response->assertStatus(200)
                 ->assertJson([
                     'email' => $this->user->email,
                     'name' => $this->user->name,
                 ]);
    }


    /** @test */
    public function it_can_update_user_settings()
    {
        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->safeEmail;
        $newPassword = $this->faker->password(8,16);

        $response = $this->actingAs($this->user, 'api')
                         ->putJson(route('settings.update'), [
                             'name' => $newName,
                             'email' => $newEmail,
                             'old_password' => $this->password,
                             'password' => $newPassword,
                         ]);

        $response->assertStatus(200);

        // Assert the user was updated correctly
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $newName,
            'email' => $newEmail,
        ]);

        $this->assertTrue(Hash::check($newPassword, $this->user->fresh()->password));
    }
}

