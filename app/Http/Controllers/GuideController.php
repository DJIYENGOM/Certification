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

    public function ChangerStatutGuideEn_NoDispo($GuideId)
    {
        $guide = Guide::findOrFail($GuideId);
         
        // Vérifiez si le guide est disponible
        if ($guide->disponibilite === 'disponible' ) {
            $guide->disponibilite = 'non disponible';
            $guide->save();
            return response()->json(['message' => 'Guide ' . $guide->name.' est maintemnant non disponible']);
        }

        return response()->json(['message' => 'Guide ' . $guide->name. ' est deja non disponible']);
    }
   

    public function ChangerStatutGuideEn_Dispo($GuideId)
    {
        $guide = Guide::findOrFail($GuideId);
         
        // Vérifiez si le guide est non disponible
        if ($guide->disponibilite === 'non disponible' ) {
            $guide->disponibilite = 'disponible';
            $guide->save();
            return response()->json(['message' => 'Guide ' . $guide->name.' est maintenant disponible']);
        }

        return response()->json(['message' => 'Guide ' . $guide->name. ' est deja disponible']);
    }
}
