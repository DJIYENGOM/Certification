<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

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
        return $this->belongsTo(User::class);
    }
}
