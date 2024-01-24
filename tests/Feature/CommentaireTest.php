<?php

namespace Tests\Feature;

use App\Models\Commentaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentaireTest extends TestCase
{
    public function testFaireCommentaire(): void
    {
        $createUser= User::factory()->create(['email' => 'gomedjie@gmail.com', 'password' => '123456']);
        $this->actingAs($createUser,'api');

        $commentaire= Commentaire::factory()->create();
        $commentaires=$commentaire->toArray();
        $this->assertDatabaseHas('commentaires',$commentaires);
    }

    public function testSupprimerCommentaire(): void
    {
        $createUser= User::factory()->create(['email' => 'derdj@gmail.com', 'password' => '123456']);
        $this->actingAs($createUser,'api');
        $commentaire=Commentaire::Find(2);
        $response = $this->delete('api/supprimerCommentaire/'.$commentaire->id);
        $response->assertStatus(200);
    }

    public function testListeCommentaire()
    {
        $response=$this->get('api/listerCommentaires/3');
        $response->assertStatus(200);
    }

    public function testNombreCommentaire()
    {
        $response=$this->get('api/compterCommentaires/3');
        $response->assertStatus(200);
    }
}