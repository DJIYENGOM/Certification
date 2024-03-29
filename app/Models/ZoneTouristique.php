<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneTouristique extends Model
{
    use HasFactory;

    protected $table = 'zone_touristiques';

    protected $fillable = ['nom', 'description', 'duree','cout', 'images', 'statut','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }


    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function like()
    {
        return $this->hasMany(like::class);
    }

    public function guides()
    {
        return $this->hasMany(Guide::class);
    }
}