<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneTouristique extends Model
{
    use HasFactory;

    protected $table = 'zone_touristiques';

    protected $fillable = ['nom', 'description', 'lieu', 'images', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
}