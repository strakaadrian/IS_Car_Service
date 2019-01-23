<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{


    /**
     * Funkcia dotiahne rezervacie prihlaseneho usera a vypise ich do pohladu
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $reserModel = new Reservation;

        $reserv = $reserModel->getReservations();

        return view('reservation', compact('reserv','reserModel'));
    }

    /**
     * Funkcia, ktorá odstráni z tabuľky reservations záznam podľa reservation_id
     *
     * @param Request $request
     *
     */
    public function deleteFromReservations(Request $request) {
        $reserModel = new Reservation;
        $reserModel->deleteFromReservationsById($request->reservation_id);
    }

}
