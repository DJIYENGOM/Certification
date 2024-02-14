<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Guide;
use App\Models\Reservation;
use App\Models\ZoneTouristique;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testFaireReservation(): void
    {
        $createUser= User::factory()->create(['email' => 'gom2RTRe@gmail.com', 'password' => '123456']);
        $this->actingAs($createUser,'api');

        $reservation= Reservation::factory()->create();
        $reservations=$reservation->toArray();
        $this->assertDatabaseHas('reservations',$reservations);
    }
    public function test_listerReservations_Par_Visiteur()
    {
        $createUser= User::factory()->create(['email' => 'go57fdjie@gmail.com', 'password' => '123456']);
        $this->actingAs($createUser,'api');

        $response=$this->get('api/Mes_reservations');
        $response->assertStatus(200);
    }

    // use RefreshDatabase;
    public function testAnnulerReservation(): void
    {
        // Créez un utilisateur (si ce n'est pas déjà fait)
        $createUser = User::factory()->create([
            'email' => 'QS@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    
        // Authentifiez l'utilisateur
        $this->actingAs($createUser, 'api');
    
        // Créez une réservation (si ce n'est pas déjà fait)
        $reservation = Reservation::factory()->create();
    
        // Appelez la route pour annuler la réservation
        $response = $this->put('api/reservations/annuler/' . $reservation->id);
    
        // Assurez-vous que la réponse est 200 (OK)
            $response->assertStatus(200);
    }
    

    public function testAccepterReservation(): void
    {
        // Créez un utilisateur (si ce n'est pas déjà fait)
        $createUser = Guide::factory()->create([
            'email' => 'gomdxChm9@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        // Authentifiez l'utilisateur
        $this->actingAs($createUser, 'apiguide');

        $visiteur= User::factory()->create();
        $zone= ZoneTouristique::factory()->create();

        // Créez une réservation (si ce n'est pas déjà fait)
        $reservation = Reservation::factory()->create(['guide'=>$createUser->id, 'visiteur'=>$visiteur->id,'zone'=>$zone->id]);

       // dd($reservation);
        // Appelez la route pour annuler la réservation
        $response = $this->put('api/reservations/accepter/' . $reservation->id);
        // dd($response);
    
        // Assurez-vous que la réponse est 200 (OK)
        $response->assertStatus(200);
    }

    public function testRefuserReservation(): void
    {
        // Créez un utilisateur (si ce n'est pas déjà fait)
        $createUser = Guide::factory()->create([
            'email' => 'gomd3679@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    
        // Authentifiez l'utilisateur
        $this->actingAs($createUser, 'apiguide');
    
        $visiteur= User::factory()->create();
        $zone= ZoneTouristique::factory()->create();

        // Créez une réservation (si ce n'est pas déjà fait)
        $reservation = Reservation::factory()->create(['guide'=>$createUser->id, 'visiteur'=>$visiteur->id,'zone'=>$zone->id]);

        // Appelez la route pour annuler la réservation
        $response = $this->put('api/reservations/refuser/' . $reservation->id);
    
        // Assurez-vous que la réponse est 200 (OK)
        $response->assertStatus(200);
    }
    
}
