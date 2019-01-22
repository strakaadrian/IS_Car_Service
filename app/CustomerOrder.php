<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CustomerOrder extends Model
{
    protected $table = 'customer_order';

    public $timestamps = false;

    /**
     * Funkcia, ktorá dotiahne všetky objednávky daného zákazníka
     *
     * @return mixed
     */
    public function getOrdersByUserId() {
        return CustomerOrder::whereRaw('identification_no in (select identification_no from Customer where user_id = ?)',[Auth::user()->id])->get();
    }

    /**
     * Funkcia nám dotiahne vsetky autosuciastky podla id objednávky
     *
     * @param $car_part_id
     * @return mixed
     */
    public function getCarParts($order_id) {
        $result = OrderItems::where('order_id', $order_id)
            ->join('car_parts','car_parts.car_part_id', '=', 'order_items.car_part_id')
            ->select('car_parts.car_part_id', 'car_parts.part_name', 'car_parts.part_price','order_items.quantity')
            ->get();

        return $result;
    }

    /**
     * Funkcia, ktorá dotiahne údaje o rezervaci na zaklade order_id
     *
     * @param $order_id
     * @return mixed
     */
    public function getReservationsByOrderId($order_id) {
        $result = Reservation::where('order_id', $order_id)
            ->join('services','services.service_id', '=', 'reservation.service_id')
            ->select('services.name', 'services.price_per_hour', 'reservation.work_hours')
            ->get();

        return $result;
    }

    /**
     * Funkcia, ktorá nám vrati podla ID  údaje o človeku
     *
     * @return mixed
     */
    public function getPersonByOrderId() {
        $result = Customer::where('user_id', Auth::user()->id)
            ->join('person','person.identification_no', '=', 'customer.identification_no')
            ->join('town','town.town_id', '=', 'person.town_id')
            ->select('person.first_name', 'person.last_name', 'person.street', 'person.orientation_no', 'town.town_name', 'town.town_id')
            ->get();

        return $result;
    }

    /**
     * Funkcia, sluzi na overenie zakaznika, ci je skutocne ten co si moze prezerat danu objednavku
     *
     * @param $order_id
     * @return mixed
     */
    public function checkOrderAuth($order_id) {
        $result = Customer::where([
            ['Customer.user_id', Auth::user()->id],
            ['customer_order.order_id',$order_id]])
            ->join('customer_order','customer_order.identification_no', '=', 'customer.identification_no')
            ->get();

        return $result;
    }

}
