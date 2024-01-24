<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MailReservation;
use App\Notifications\MailRefuReservation;
use App\Notifications\MailAcceptReservation;
use App\Notifications\AnnulationDeLaReservation;

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
            'zone' => 'required|exists:zone_touristiques,id',
            'guide' => 'required|exists:users,id,role,guide',
 
        ]);

        $reservation = new Reservation($request->all());
        $reservation->visiteur= auth()->user()->id;
        $reservation->reservation_annuler = false; // Par défaut, la réservation n'est pas annulée
        $reservation->validation = 'encours'; // Par défaut, la réservation est en cours de validation
        $reservation->save();

        $user = User::find($reservation->visiteur);
         $user->notify(new MailReservation());

        return response()->json(['message' => 'Votre réservation a été bien prise en charge. Veuillez vérifier votre boite e-mail.']);

       
    }

    public function listerReservations()
    {
        $reservations = Reservation::all();
        return response()->json($reservations);
    }
    public function listerReservationsParVisiteur()
    {
        $user = auth()->user();
        $reservations = Reservation::where('visiteur', $user->id)->get();
        return response()->json($reservations);
    }

    public function annulerReservation($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $user = auth()->user();
    
        // Vérifiez si l'utilisateur connecté est le visiteur associé à la réservation
        if ($user->id !== $reservation->visiteur) {
            return response()->json(['message' => 'Vous n\'avez pas la permission d\'annuler cette réservation.'], 403);
        }
    
        // Vérifiez si la réservation peut être annulée
        if ($reservation->validation === 'encours' && !$reservation->reservation_annuler) {
            $reservation->reservation_annuler = true;
            $reservation->save();
            $user = User::find($reservation->guidedd);
            $user->notify(new AnnulationDeLaReservation());
            
            return response()->json(['message' => 'Réservation annulée avec succès']);
        }
    
        return response()->json(['message' => 'Impossible d\'annuler la réservation car elle est déjà traitée']);
    }
    

    public function accepterReservation($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        
        $user = auth()->user();
       // Vérifiez si l'utilisateur connecté est le guide associé à la réservation
        if ($user->id !== $reservation->guide) {
            return response()->json(['message' => 'Vous n\'avez pas la permission d\'annuler cette réservation.'], 403);
        }

        // Vérifiez si la réservation peut être acceptée
        if ($reservation->validation === 'encours' && !$reservation->reservation_annuler) {
            $reservation->validation = 'accepter';
            $reservation->save();
            $user = User::find($reservation->visiteur);
            $user->notify(new MailAcceptReservation());
            return response()->json(['message' => 'Réservation acceptée avec succès']);
        }

        return response()->json(['message' => 'Impossible accepter la réservation']);
    }

    public function refuserReservation($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        $user = auth()->user();
        // Vérifiez si l'utilisateur connecté est le guide associé à la réservation
         if ($user->id !== $reservation->guide) {
             return response()->json(['message' => 'Vous n\'avez pas la permission d\'annuler cette réservation.'], 403);
         }
         
        // Vérifiez si la réservation peut être refusée
        if ($reservation->validation === 'encours' && !$reservation->reservation_annuler) {
            $reservation->validation = 'refuser';
            $reservation->save();
               
            $user = User::find($reservation->visiteur);
            $user->notify(new MailRefuReservation());

            return response()->json(['message' => 'Réservation refusée avec succès']);
        }

        return response()->json(['message' => 'Impossible de refuser la réservation']);
    }
    
}