<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class MusicaTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_musicas()
    {
        $response = $this->getJson('/api/musicas');
        $response->assertStatus(200);
    }

    public function test_admin_can_add_music()
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        $response = $this->postJson('/api/musicas', [
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
        ]);

        $response->assertStatus(201);
    }
}
