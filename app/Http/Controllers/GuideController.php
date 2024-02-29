<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Http\Requests\StoreGuideRequest;
use App\Http\Requests\UpdateGuideRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listerGuides()
    {
        $guides = Guide::All();
        return response()->json($guides);
    }

    public function listeGuideDispo()
    {
        $guides = Guide::where('disponibilite', 'disponible')->get();
        return response()->json($guides);
    }

    public function listerGuidesParZone($zoneId)
    {
        $guides = Guide::where('zone_id', $zoneId)->get();
        return response()->json($guides);
    }

    public function ChangerStatutGuideEn_NoDispo()
    {
        $guide = auth('apiguide')->user();
        
        $guide = Guide::findOrFail($guide->id);;
         
        // Vérifiez si le guide est disponible
            if ($guide->disponibilite === 'disponible' ) {
                $guide->disponibilite = 'non disponible';
                $guide->save();
                return response()->json(['message' => 'Votre statut a été changé en non disponible avec succès']);
        }
        return response()->json(['message' => 'Votre statut est deja non disponible']);
    
    }

    //oubien pour disponibilité
    public function ChangerStatutGuideEn_Dispo()
    {
        $guide = auth('apiguide')->user();
        
    
        $guide = Guide::findOrFail($guide->id);;
         
        // Vérifiez si le guide est non disponible
        if ($guide->disponibilite === 'non disponible' ) {
            $guide->disponibilite = 'disponible';
            $guide->save();
            return response()->json(['message' => ' Votre statut est maintenant disponible']);
        }

        return response()->json(['message' => 'Votre statut  est deja disponible']);
      

   }

   public function updateProfile(Request $request)
   {
       // Récupérer l'utilisateur authentifié
       $guide = auth('apiguide')->user();
       
       // Validation des données
       $validator = Validator::make($request->all(), [
        'name' =>  ['required', 'string', 'min:2', 'regex:/^[a-zA-Z ]+$/'],
        'telephone' => ['required', 'regex:/^7\d{8}$/'],
        'description'=> 'required|string',
        'duree_experience' => ['required', 'regex:/^\d{1,2}(mois|ans)$/'],
        'zone_id' => 'required|exists:zone_touristiques,id',
        'image' => 'sometimes'
    ]);
    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors(),
        ],422);
    }
    $imageName=null;
    if($request->hasFile('image')){
        $imageName=$request->file('image')->store('image', 'public');
         }
   
       // Mise à jour des informations de l'utilisateur
       $guide->name = $request->name;
       $guide->telephone = $request->telephone;
       $guide->description = $request->description;
       $guide->duree_experience = $request->duree_experience;
       $guide->zone_id = $request->zone_id;
       $guide->image = $imageName;
   
       // Enregistrer les modifications dans la base de données
   
       
       $guide->update();
       return response()->json(['message' => 'Profil mis à jour avec succès', 'guide' => $guide]);
   }

   public function refresh_guide()
   {
       return response()->json([
           'user' => Auth::guard('apiguide')->user(),
           'authorisation' => [
               'token' => Auth::refresh(),
               'type' => 'bearer',
           ]
       ]);
   }
}