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
        $reservation = new Reservation;

        $reserv = $reservation->getReservations();

        return view('reservation', compact('reserv'));
    }
}
