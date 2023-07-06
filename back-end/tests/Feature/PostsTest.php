<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostsTest extends TestCase
{
    use RefreshDatabase;
    private $user;
    private $nonExistentId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->nonExistentId = Post::max('id') + 1; //Impossible ID in normal situation
    }

    public function test_can_view_all_user_posts()
    {
        $this->actingAs($this->user, 'api');

        Post::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/posts');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_can_view_single_post()
    {
        $this->actingAs($this->user, 'api');

        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertJson(['data' => $post->toArray()]);
    }

    public function test_can_create_post()
    {
        $this->actingAs($this->user, 'api');

        $postData = [
            'title' => 'Test Title',
            'description' => 'Test Description'
        ];

        $response = $this->post('/api/posts', $postData);

        $response->assertStatus(201);
        $response->assertJson(['data' => $postData]);
    }

    public function test_can_update_post()
    {
        $this->actingAs($this->user, 'api');

        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description'
        ];

        $response = $this->put('/api/posts/' . $post->id, $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_can_delete_post()
    {
        $this->actingAs($this->user, 'api');

        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete('/api/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_view_non_existent_post()
    {
        $this->actingAs($this->user, 'api');

        $response = $this->get("/api/posts/$this->nonExistentId");

        $response->assertStatus(404);
        $response->assertJson(['success' => false, 'message' => 'Post not found']);
    }

    public function test_update_non_existent_post()
    {
        $this->actingAs($this->user, 'api');

        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description'
        ];

        $response = $this->put("/api/posts/$this->nonExistentId", $updatedData);

        $response->assertStatus(404);
        $response->assertJson(['success' => false, 'message' => 'Post not found']);
    }
    public function test_delete_non_existent_post()
    {
        $this->actingAs($this->user, 'api');

        $response = $this->delete("/api/posts/$this->nonExistentId");

        $response->assertStatus(404);
        $response->assertJson(['success' => false, 'message' => 'Post not found']);
    }
    public function test_create_post_with_invalid_data()
    {
        $this->actingAs($this->user, 'api');

        $postData = [
            'title' => '',
            'description' => ''
        ];

        $response = $this->post('/api/posts', $postData);

        $response->assertStatus(400);
    }

}
