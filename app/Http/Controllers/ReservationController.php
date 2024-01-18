<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function faireReservation(Request $request)
    {

        //dd($request->all());
        $request->validate([
            'Nom' => 'required|string',
            'email' => 'required|email',
            'telephone' => 'required|string',
            'nombre_de_personnes' => 'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'zone_id' => 'required|exists:zone_touristiques,id',
            'user_id' => 'required|exists:users,id,role,guide'
        ]);

        
        $reservation = new Reservation($request->all());
        $reservation->reservation_annuler = false; // Par défaut, la réservation n'est pas annulée
        $reservation->validation = 'encours'; // Par défaut, la réservation est en cours de validation
        $reservation->save();

        return response()->json(['message' => 'Réservation effectuée avec succès']);
    }

    public function listerReservations()
    {
        $reservations = Reservation::all();
        return response()->json($reservations);
    }

    public function annulerReservation($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        // Vérifiez si la réservation peut être annulée
        if ($reservation->validation === 'encours' && !$reservation->reservation_annuler) {
            $reservation->reservation_annuler = true;
            $reservation->save();
            return response()->json(['message' => 'Réservation annulée avec succès']);
        }

        return response()->json(['message' => 'Impossible de annuler la réservation car elle est deja traitée']);
    }

    public function accepterReservation($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        // Vérifiez si la réservation peut être acceptée
        if ($reservation->validation === 'encours' && !$reservation->reservation_annuler) {
            $reservation->validation = 'accepter';
            $reservation->save();
            return response()->json(['message' => 'Réservation acceptée avec succès']);
        }

        return response()->json(['message' => 'Impossible accepter la réservation']);
    }

    public function refuserReservation($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        // Vérifiez si la réservation peut être refusée
        if ($reservation->validation === 'encours' && !$reservation->reservation_annuler) {
            $reservation->validation = 'refuser';
            $reservation->save();
            return response()->json(['message' => 'Réservation refusée avec succès']);
        }

        return response()->json(['message' => 'Impossible de refuser la réservation']);
    }
}