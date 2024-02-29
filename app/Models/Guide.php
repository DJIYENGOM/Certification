<?php
namespace App\Models;
use App\Models\Reservation;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guide extends Authenticatable implements JWTSubject
{
    use HasFactory, HasApiTokens,Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'description',
        'duree_experience',
        'image',
        'zone_id',
        'telephone', 
        'disponibilite'

    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zones()
    {
        return $this->belongsTo(ZoneTouristique::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
