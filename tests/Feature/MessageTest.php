<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageTest extends TestCase
{
    public function testEnvoyerMessage(): void
    {
        $createUser= User::factory()->create(['email' => 'djie097@gmail.com', 'password' => '123456']);
        $this->actingAs($createUser,'api');

        $message= Message::factory()->create();
        $messages=$message->toArray();
        $this->assertDatabaseHas('messages',$messages);
    }

    public function testEnvoyerReponse(): void
    {
        $createUser= User::factory()->create(['email' => 'ggjht@gmail.com', 'password' => '123456','role' => 'admin']);
        $this->actingAs($createUser,'api');

        $message= Message::factory()->create();
        $response = $this->get('api/response');
        $response->assertStatus(200);
    }
}
