<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Http\Requests\StoreGuideRequest;
use App\Http\Requests\UpdateGuideRequest;

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


}