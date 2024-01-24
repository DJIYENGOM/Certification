<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ZoneTouristique;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ZoneTest extends TestCase
{
   
    public function testAjouterZone(): void
    {
        $createUser= User::factory()->create(['email' => 'gomerdjie@gmail.com', 'password' => '123456']);
        $this->actingAs($createUser,'api');

        $Zone= ZoneTouristique::factory()->create();
        $Zones=$Zone->toArray();
        $this->assertDatabaseHas('zone_Touristiques',$Zones);
    }

    public function testListeZone()
    {
        $response=$this->get('api/listeZone');
        $response->assertStatus(200);
    }
  
    public function testDetailZone()
    {
        $response=$this->get('api/detailZone/3');
        $response->assertStatus(200);
    }

    public function testModifierZone(): void
    {
        $createUser= User::factory()->create(['email' => 'dffgerdjie@gmail.com', 'password' => '123456']);
        $this->actingAs($createUser,'api');
        $zone=[
            'nom' => "Gorée",
            'description' => "ville touristique",
            'lieu' => "Dakar",
            'images' => null, // Vous pouvez ajuster cela selon vos besoins
            'user_id' => 1,
        ];
        $zones=ZoneTouristique::Find(2);
        $response = $this->put('api/modifierZone/'.$zones->id, $zone);
        $response->assertStatus(200);
    }

    public function testSupprimerZone(): void
    {
        $createUser= User::factory()->create(['email' => 'derdjie@gmail.com', 'password' => '123456']);
        $this->actingAs($createUser,'api');
        $zones=ZoneTouristique::Find(2);
        $response = $this->delete('api/supprimerZone/'.$zones->id);
        $response->assertStatus(200);
    }
}
