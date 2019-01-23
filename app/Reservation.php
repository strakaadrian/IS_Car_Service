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


    /**
     * Funkcia vytvori zaznam v tabulke rezervacii
     *
     * @param $ico
     * @param $service_id
     * @param $date
     * @param $hour
     * @return array
     */
    public function dataInsertReservation($ico, $service_id, $date, $hour) {
        return DB::select("call create_reservation(?, ?, ?, ?, ?)",[Auth::user()->id,$ico,$service_id,$date,$hour]);
    }

    /**
     * Funkcia vrati aktualne rezervacie prihlaseneho usera
     *
     * @return \Illuminate\Support\Collection
     */
    public function getReservations(){
        $reservations = DB::table('reservation')
            ->join('employee', 'employee.hire_date', '=', 'reservation.hire_date')
            ->join('car_service', 'employee.ico', '=', 'car_service.ico')
            ->join('services', 'services.service_id', '=', 'reservation.service_id')
            ->join('customer_order', 'customer_order.order_id', '=', 'reservation.order_id')
            ->join('customer', 'customer.identification_no', '=', 'customer_order.identification_no')
            ->select('reservation.reservation_id','reservation.repair_date', 'services.name', 'car_service.service_name')
            ->where([
                ['customer.user_id', '=', Auth::user()->id],
                ['reservation.repair_date', '>=', now()],
            ])
            ->get();

        return $reservations;
    }

    /**
     * Funkcia, ktorá skontroluje, čí dátum na rezervácie je aktuálny aby si mohol zákazník danú rezerváciu zrušiť
     *
     * @param $reservation_id
     * @return array
     */
    public function checkReservationDate($reservation_id) {
        return DB::select("select check_reservation_date(?) as result",[$reservation_id]);
    }

    /**
     *Funkcia, ktorá odstráni z tabuľky reservations záznam podľa reservation_id
     *
     * @param $reservation_id
     * @return array
     */
    public function deleteFromReservationsById($reservation_id) {
        return DB::select("call delete_from_reservation(?)",[$reservation_id]);
    }

}
