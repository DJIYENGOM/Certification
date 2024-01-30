<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ZoneTouristique;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ContacterWatsapController extends Controller
{
    public function redirigerWhatsApp($id)

    {
        try {
            // Validation de l'ID comme étant numérique
            if (!is_numeric($id)) {
                throw new Exception('L\'ID doit être numérique.');
            }
    
                    $proprietaire = User::findOrFail($id);

            $numeroWhatsApp = $proprietaire->telephone;
            // dd($numeroWhatsApp);
            $urlWhatsApp = "https://api.whatsapp.com/send?phone=$numeroWhatsApp";
    
            return redirect()->to($urlWhatsApp);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('redirigerWhatsApp'); // Utilisez le bon nom de route
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function Recherche(Request $request){
        $trouver=ZoneTouristique::where('nom','LIKE','%'.$request->nom.'%')->get();
        return $trouver;
    }
}
