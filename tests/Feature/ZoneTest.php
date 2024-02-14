<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ZoneTouristique;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ZoneTest extends TestCase
{
   
    public function testAjouterZone(): void
    {
        $createUser= User::factory()->create(['email' => 'gom234djie@gmail.com', 'password' => '123456']);
        $this->actingAs($createUser,'api');

        $Zone= ZoneTouristique::factory()->create();
        $Zones=$Zone->toArray();
        $this->assertDatabaseHas('zone_Touristiques',$Zones);
    }

    public function testListeZonePubliée()
    {
        $response=$this->get('api/listeZonesPubliees');
        $response->assertStatus(200);
    }
  
    public function testDetailZone()
    {
        $Zones= ZoneTouristique::factory()->create();
        $response=$this->get('api/detailZone/'.$Zones->id);
        $response->assertStatus(200);
    }

    public function testModifierZone(): void
    {
        $createUser= User::factory()->create(['email' => 'dNfvFmgfde@gmail.com', 'password' => 'password','role' => 'admin']);
        $this->actingAs($createUser,'api');
        $zone=[
            'nom' => "Gorée",
            'description' => "ville touristique",
            'lieu' => "Dakar",
            'statut' => 'non publier',
            'duree' => '2 jour',
            'cout' => ' 10000',
            'images' => null, // Vous pouvez ajuster cela selon vos besoins
            //'user_id' => $createUser->id,
        ];
        $zones= ZoneTouristique::factory()->create();
        $response = $this->post('api/modifierZone/'.$zones->id, $zone);
        $response->assertStatus(200);
    }

    public function testSupprimerZone(): void
    {
        $createUser= User::factory()->create(['email' => 'derjgbie@gmail.com', 'password' => '123456']);
        $this->actingAs($createUser,'api');

        $zones= ZoneTouristique::factory()->create();
        $response = $this->delete('api/supprimerZone/'.$zones->id);
        $response->assertStatus(200);
    }
}
