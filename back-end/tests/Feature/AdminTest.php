<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test admin and user
        $this->admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_list_all_users()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->getJson(route('admin.index'));

        $response->assertStatus(200)
                 ->assertJsonCount(2); // Expecting 2 users (admin and user)
    }

    /** @test */
    public function it_can_show_a_user()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->getJson(route('admin.show', $this->user->id));

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => $this->user->name,
                     'email' => $this->user->email,
                 ]);
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $userData = User::factory()->raw([
            'is_admin' => 0,
        ]);

        unset($userData['remember_token']);

        $response = $this->actingAs($this->admin, 'api')
                        ->postJson(route('admin.store'), $userData);

        $response->assertStatus(201)
                ->assertJson(['message' => 'User created successfully']);

        unset($userData['password']); // We can't compare hashed password
        $this->assertDatabaseHas('users', $userData);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $userData = User::factory()->raw([
            'is_admin' => 0,
        ]);

        unset($userData['remember_token']);

        $response = $this->actingAs($this->admin, 'api')
                        ->putJson(route('admin.update', $this->user->id), $userData);

        $response->assertStatus(200)
                ->assertJson(['message' => 'User updated successfully']);

        unset($userData['password']); // We can't compare hashed password
        $this->assertDatabaseHas('users', $userData);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->deleteJson(route('admin.destroy', $this->user->id));

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }

    /** @test */
    public function it_cannot_access_admin_functions_without_authorization()
    {
        $response = $this->getJson(route('admin.index'));

        $response->assertStatus(401);
    }

    /** @test */
    public function it_cannot_access_admin_functions_as_regular_user()
    {
        $response = $this->actingAs($this->user, 'api')
                        ->getJson(route('admin.index'));

        $response->assertStatus(401);
    }

    /** @test */
    public function it_cannot_update_nonexistent_user()
    {
        $userData = User::factory()->raw([
            'is_admin' => 0,
        ]);

        unset($userData['remember_token']);

        $nonExistentId = User::max('id') + 1; //Impossible ID in normal situation

        $response = $this->actingAs($this->admin, 'api')
                        ->putJson(route('admin.update', $nonExistentId), $userData);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_cannot_delete_nonexistent_user()
    {
        $nonExistentId = User::max('id') + 1; //Impossible ID in normal situation

        $response = $this->actingAs($this->admin, 'api')
                        ->deleteJson(route('admin.destroy', $nonExistentId));

        $response->assertStatus(404);
    }


}
