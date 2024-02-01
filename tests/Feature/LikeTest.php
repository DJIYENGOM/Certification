<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testFaireLike(): void
    {
        $createUser= User::factory()->create(['email' => 'go23d23e@gmail.com', 'password' => '123456']);
        $this->actingAs($createUser,'api');

        $like= Like::factory()->create();
        $likes=$like->toArray();
        $this->assertDatabaseHas('likes',$likes);
    }

    public function testNombreLike()
    {
        $response=$this->get('api/compterNombreLike/3');
        $response->assertStatus(200);
    }
}
