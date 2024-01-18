<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('Nom');
            $table->string('email');
            $table->string('telephone');
            $table->integer('nombre_de_personnes');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('reservation_annuler')->default(false);
            $table->enum('validation', ['encours', 'accepter', 'refuser'])->default('encours');
            $table->unsignedBigInteger('zone_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('zone_id')->references('id')->on('zone_touristiques')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
}
