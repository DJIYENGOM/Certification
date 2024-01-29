<?php

namespace App\Http\Controllers;

use App\Models\ZoneTouristique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ZoneController extends Controller
{
    public function index()
    {
        $zonesTouristiques = ZoneTouristique::all();
        return response()->json($zonesTouristiques);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'nom' => 'required|string',
            'description' => 'required|string',
            'duree' => 'required|string',
            'cout' => 'required|string',
            'images.*' => 'sometimes'
        ]);

      
    
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
    

    public function show(ZoneTouristique $zoneTouristique)
    {
        return response()->json($zoneTouristique);
    }

    public function update(Request $request, ZoneTouristique $zoneTouristique)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'required|string',
            'duree' => 'required|string',
            'cout' => 'required|string',   
            'images' => 'nullable|file',

        ]);

        $zoneTouristique->update($request->all());

        return response()->json(['message' => 'Zone touristique mise à jour avec succès']);
    }

    public function destroy(ZoneTouristique $zoneTouristique)
    {
        $zoneTouristique->delete();

        return response()->json(['message' => 'Zone touristique supprimée avec succès']);
    }
}
