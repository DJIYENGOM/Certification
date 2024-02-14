<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ZoneTouristique;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NouvellePublication;

class ZoneController extends Controller
{
    public function index()
    {
     
        $zonesTouristiques = Cache::remember('zonesTouristiques',3600, function () {
            return ZoneTouristique::all();
        });
        return response()->json($zonesTouristiques);
    }

    public function compterNombreZones()
      {
          // Récupère le nombre de zones touristiques
          $nombreZone = ZoneTouristique::all()->count();
          // Retourne le nombre de zones sous forme de réponse JSON
          return response()->json(['nombre de Zones' => $nombreZone]);
      }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator=Validator::make($request->all(),[
        
            'nom' => 'required|string',
            'description' => 'required|string',
            'duree' => 'required|string',
            'cout' => 'required|string',
            'images.*' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ],422);
        }
    
        // Utilisez l'authentification pour récupérer l'utilisateur actuel
        $user = auth()->user();
        // Créez une nouvelle instance de ZoneTouristique avec les données fournies et l'ID de l'utilisateur
        $zoneTouristique = new ZoneTouristique();
        
            if($request->hasFile('images')){
           $monimage=$request->file('images')->store('images', 'public');
           $zoneTouristique->images = $monimage;

            }
            $zoneTouristique->nom = $request->input('nom');
            $zoneTouristique->description =$request->input('description');
            $zoneTouristique->duree = $request->input('duree');
            $zoneTouristique->cout = $request->input('cout');  
            $zoneTouristique->user_id = $user->id;
        
    
        // Sauvegardez la zone touristique dans la base de données
        $zoneTouristique->save();
    
        // Retournez une réponse JSON
        return response()->json(['message' => 'Zone touristique ajoutée avec succès']);
    }
    

    public function detailZone(ZoneTouristique $zoneTouristique)
    {
        return response()->json($zoneTouristique);
    }
    public function listeZonesPubliees()
    {
        $zones = ZoneTouristique::where('statut', 'publier')->get();
        return response()->json($zones);
    }

    public function update(Request $request, ZoneTouristique $zoneTouristique)
    {
       // dd($request->all());
       $validator=Validator::make($request->all(),[

            'nom' => 'required|string',
            'description' => 'required|string',
            'duree' => 'required|string',
            'cout' => 'required|string',   
            'images.*' => 'sometimes'

        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ],422);
        }
        $zoneTouristique->fill($request->all());
        if($request->hasFile('images')){
            $monimage=$request->file('images')->store('images', 'public');
            $zoneTouristique->images = $monimage;
 
             }
           
        $zoneTouristique->update();

        return response()->json(['message' => 'Zone touristique mise à jour avec succès']);
    }

    public function destroy(ZoneTouristique $zoneTouristique)
    {
        $zoneTouristique->delete();

        return response()->json(['message' => 'Zone touristique supprimée avec succès']);
    }


    public function PublierZone($ZoneId)
    {
        $zone = ZoneTouristique::findOrFail($ZoneId);

        $user = auth()->user();
        // Vérifiez si l'utilisateur connecté est le guide associé à la réservation
         if ($user->id !== $zone->user_id) {
             return response()->json(['message' => 'Vous n\'avez pas la permission d\'effectuer cette action.'], 403);
         }
         
        // Vérifiez si la réservation peut être refusée
        if ($zone->statut === 'non publier' ) {
            $zone->statut = 'publier';
            $zone->save();
               
            $users = User::where('role', 'visiteur')->get();
            foreach ($users as $user) {
                $user->notify(new NouvellePublication());
            }
         

            return response()->json(['message' => 'Zone publiee avec succès']);
        }

        return response()->json(['message' => 'Cette zone est deja publiee']);
    }
}
