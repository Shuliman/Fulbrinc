<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $password;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->password = $this->faker->password(8, 16);
        $this->user = User::factory()->create([
            'password' => bcrypt($this->password),
        ]);
    }

    public function test_it_can_retrieve_user_settings()
    {
        $response = $this->actingAs($this->user, 'api')
            ->getJson(route('settings.index'));

        $response->assertStatus(200)
            ->assertJson([
                'email' => $this->user->email,
                'name' => $this->user->name,
            ]);
    }


    public function test_it_can_update_user_settings()
    {
        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->safeEmail;
        $newPassword = $this->faker->password(8, 16);

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

    public function test_it_cannot_update_user_settings_with_invalid_name()
    {
        $response = $this->actingAs($this->user, 'api')
            ->putJson(route('settings.update'), [
                'name' => '', // Invalid name
                'email' => $this->faker->unique()->safeEmail,
                'old_password' => $this->password,
                'password' => $this->faker->password(8, 16),
            ]);

        $response->assertStatus(400);
    }

    public function test_it_cannot_update_user_settings_with_invalid_email()
    {
        $response = $this->actingAs($this->user, 'api')
            ->putJson(route('settings.update'), [
                'name' => $this->faker->name,
                'email' => 'not-an-email', // Invalid email
                'old_password' => $this->password,
                'password' => $this->faker->password(8, 16),
            ]);

        $response->assertStatus(400);
    }

    public function test_it_cannot_update_user_settings_with_invalid_old_password()
    {
        $response = $this->actingAs($this->user, 'api')
            ->putJson(route('settings.update'), [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'old_password' => 'wrong-password', // Invalid old password
                'password' => $this->faker->password(8, 16),
            ]);

        $response->assertStatus(400);
    }

    public function test_it_cannot_update_user_settings_with_invalid_new_password()
    {
        $response = $this->actingAs($this->user, 'api')
            ->putJson(route('settings.update'), [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'old_password' => $this->password,
                'password' => 'short', // Invalid new password
            ]);

        $response->assertStatus(400);
    }
}
