<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ZoneController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(ZoneController::class)->group(function () {
    Route::get('listeZone', 'index');
    Route::get('detailZone/{zoneTouristique}', 'show');
});

    Route::post('/ajouterCommentaire/{zoneId}', [CommentaireController::class, 'ajouterCommentaire']);
    Route::get('/listerCommentaires/{zoneId}', [CommentaireController::class, 'listerCommentaires']);
    Route::get('/compterCommentaires/{zoneId}', [CommentaireController::class, 'compterCommentaires']);

    Route::post('/reservations', [ReservationController::class, 'faireReservation']);
    Route::get('/reservations', [ReservationController::class, 'listerReservations']);
    Route::put('/reservations/{reservationId}/annuler', [ReservationController::class, 'annulerReservation']);
    Route::put('/reservations/{reservationId}/accepter', [ReservationController::class, 'accepterReservation']);
    Route::put('/reservations/{reservationId}/refuser', [ReservationController::class, 'refuserReservation']);


    Route::middleware(['auth','role:admin'])->group(function () {
      
        Route::post('/create-guide', [AuthController::class, 'createGuide']);
        Route::get('/listerGuide', [AuthController::class, 'listerGuides']);
        Route::delete('/delete-guide/{userId}', [AuthController::class, 'deleteGuide']);
        Route::post('ajoutZone', [ZoneController::class, 'store']);
        Route::post('modifierZone/{zoneTouristique}', [ZoneController::class, 'update']);
        Route::get('supprimerZone/{zoneTouristique}',  [ZoneController::class, 'destroy']);
        Route::delete('/supprimerCommentaire/{commentaireId}', [CommentaireController::class, 'supprimerCommentaire']);

    });

    Route::post('/modifierCompte', [AuthController::class, 'updateProfile']);
 