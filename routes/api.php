<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ZoneController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(ZoneController::class)->group(function () {
    Route::post('ajoutZone', 'store');
    Route::get('listeZone', 'index');
    Route::get('detailZone/{zoneTouristique}', 'show');
    Route::post('modifierZone/{zoneTouristique}', 'update');
    Route::get('supprimerZone/{zoneTouristique}', 'destroy');
});

    Route::post('/ajouterCommentaire/{zoneId}', [CommentaireController::class, 'ajouterCommentaire']);
    Route::delete('/supprimerCommentaire/{commentaireId}', [CommentaireController::class, 'supprimerCommentaire']);
    Route::get('/listerCommentaires/{zoneId}', [CommentaireController::class, 'listerCommentaires']);
    Route::get('/compterCommentaires/{zoneId}', [CommentaireController::class, 'compterCommentaires']);

    Route::post('/reservations', [ReservationController::class, 'faireReservation']);
    Route::get('/reservations', [ReservationController::class, 'listerReservations']);
    Route::put('/reservations/{reservationId}/annuler', [ReservationController::class, 'annulerReservation']);
    Route::put('/reservations/{reservationId}/accepter', [ReservationController::class, 'accepterReservation']);
    Route::put('/reservations/{reservationId}/refuser', [ReservationController::class, 'refuserReservation']);


   // Route::middleware('auth')->group(function () {
      
        Route::post('/create-guide', [Controller::class, 'createGuide']);
        Route::get('/listerGuide', [Controller::class, 'listerGuides']);
        Route::delete('/delete-guide/{userId}', [Controller::class, 'deleteGuide']);

    //});