<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;


    protected $fillable = [
        'contenu',
        'user_id',
        'zone_id',

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
