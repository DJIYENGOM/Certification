<?php

namespace App\Models;

use App\Models\Guide;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsTo(ZoneTouristique::class,'zone');
    }

    
    public function guider()
    {
        return $this->belongsTo(Guide::class,'guide');
    }
}
