<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ContacterWatsapController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PasswordOublierController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ZoneController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('login/guide', 'login_guide');
    Route::post('refresh', 'refresh');
});

Route::controller(ZoneController::class)->group(function () {
    Route::get('listeZonesPubliees', 'listeZonesPubliees');
    Route::get('detailZone/{zoneTouristique}', 'detailZone');
});

    Route::post('/ajouterCommentaire/{zoneId}', [CommentaireController::class, 'ajouterCommentaire']);
    Route::get('/listerCommentaires/{zoneId}', [CommentaireController::class, 'listerCommentaires']);
    Route::get('/compterCommentaires/{zoneId}', [CommentaireController::class, 'compterCommentaires']);

    Route::post('/Faire-reservations', [ReservationController::class, 'faireReservation']);
    Route::get('/Mes_reservations', [ReservationController::class, 'listerReservationsParVisiteur']);
    Route::put('/reservations/annuler/{reservationId}', [ReservationController::class, 'annulerReservation']);

    Route::middleware(['auth:api', 'role:admin'])->group(function () {
       // Route::post('ajoutZone', [ZoneController::class, 'store']);

    });

    Route::middleware(['checkRole:admin'])->group(function () {
        Route::post('/create-guide', [AuthController::class, 'createGuide']);
        Route::get('/listerGuide', [AuthController::class, 'listerGuides']);
        Route::get('NombreGuides', [GuideController::class, 'compterNombreGuides']);
        Route::delete('/delete-guide/{userId}', [AuthController::class, 'deleteGuide']);

        Route::post('ajoutZone', [ZoneController::class, 'store']);
        Route::get('NombreZones', [ZoneController::class, 'compterNombreZones']);
        Route::get('listeZone', [ZoneController::class, 'index']);
        Route::get('PublierZone/{ZoneId}', [ZoneController::class, 'PublierZone']);
        Route::post('modifierZone/{zoneTouristique}', [ZoneController::class, 'update']);
        Route::delete('supprimerZone/{zoneTouristique}', [ZoneController::class, 'destroy']);
        Route::delete('/supprimerCommentaire/{commentaireId}', [CommentaireController::class, 'supprimerCommentaire']);
        Route::get('/reservations', [ReservationController::class, 'listerReservations']);
        Route::get('/listeMessage', [MessageController::class, 'listerMessage']);

    });

    Route::middleware(['checkRole:guide'])->group(function () {
        Route::put('/reservations/accepter/{reservationId}', [ReservationController::class, 'accepterReservation']);
        Route::put('/reservations/refuser/{reservationId}', [ReservationController::class, 'refuserReservation']);

    });

    Route::post('/zone-touristique/like/{id}', [LikeController::class, 'likeZoneTouristique'])->middleware('auth');
    Route::get('/compterNombreLike/{zoneId}', [LikeController::class, 'compterNombreLike']);

    Route::post('/EnvoieMessage', [MessageController::class, 'EnvoieMessage']);


    Route::post('forget-password', [PasswordOublierController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
    Route::get('reset-password/{token}', [PasswordOublierController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [PasswordOublierController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    Route::post('/redirigerWhatsApp/{id}', [ContacterWatsapController::class, 'redirigerWhatsApp']);

    Route::post('/Recherche', [ContacterWatsapController::class, 'Recherche']);

    