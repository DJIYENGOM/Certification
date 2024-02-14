<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthentificationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRegister(): void
    {
        $user= User::factory()->create();
        $users=$user->toArray();
        $this->assertDatabaseHas('users',$users);
    }
    public function testLogin(): void
    {
        //$user= User::factory()->create();
        $createUser= ['email' => 'ngomdjiye@gmail.com', 'password' => 'password'];
        $insert=$this->post('api/login',$createUser);
        $insert->assertStatus(200);
    }
}
