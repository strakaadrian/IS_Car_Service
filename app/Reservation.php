<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    protected $table = 'reservation';

    public $timestamps = false;

    /**
     * Funkcia, ktorá skontroluje, či dna daný čas, firmu a dátum už nieje rezervácia
     *
     * @param $ico
     * @param $date
     * @param $hour
     */
    public function checkReservationAtTime($ico, $date, $hour) {
        return DB::select("select get_reservations(?, ?, ?) as result",[$ico,$date,$hour]);
    }


    public function dataInsertReservation($ico, $service_id, $date, $hour) {
        return DB::select("call insert_reservation(?, ?, ?, ?, ?)",[Auth::user()->id,$ico,$service_id,$date,$hour]);
    }

}
