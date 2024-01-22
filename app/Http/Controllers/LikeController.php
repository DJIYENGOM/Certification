<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;  
use App\Http\Requests\StoreLikeRequest;  
class LikeController extends Controller
{
    public function likeZoneTouristique(Request $request, $zoneTouristiqueId)
    {
        $user = auth()->user();
    
        // Vérifiez si l'utilisateur a déjà aimé cette zone touristique
        $existingLike = Like::where('user_id', $user->id)
                            ->where('zone_id', $zoneTouristiqueId)
                            ->first();
    
        if ($existingLike) {
            return response()->json(['message' => 'Vous avez déjà aimé cette zone touristique.'], 400);
        }
    
        // Ajoutez un like
        $like = new Like([
            'user_id' => $user->id,
            'zone_id' => $zoneTouristiqueId,
        ]);
    
        $like->save();
    
        return response()->json(['message' => 'Zone touristique aimée avec succès.']);
    }

    public function compterNombreLike($zoneId)
    {
        $nombreLikes = Like::where('zone_id', $zoneId)->count();
        return response()->json(['nombre_Like' => $nombreLikes]);
    }

}