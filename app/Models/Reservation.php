<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;


    protected $fillable = [
        'Nom',
        'email',
        'telephone',
        'nombre_de_personnes',
        'date_debut',
        'date_fin',
        'reservation_annuler',
        'validation',
        'zone',
        'guide',
        'visiteur',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zonesTouristiques()
    {
        return $this->belongsTo(User::class);
    }
}
