<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    /**
     * z ktorej tabulky bude tahat data Services
     * @var string
     */
    protected $table = 'services';

    public $timestamps = false;

    /**
     * tato funkcia nam skontroluje ci zadany datum splna poziadavky / ci je aktualny a ci to nieje vikend
     * @param $date
     * @return array
     */
    public function checkDay($date) {
        return DB::select("select get_day_name(?) as result",[$date]);
    }

    /**
     * Funkcia updatne tabulku services podla ID
     *
     * @param $service_id
     * @param $hour_duration
     * @param $price_per_hour
     * @return array
     */
    public function updateServicesByID($service_id, $hour_duration, $price_per_hour) {
        return DB::select("call update_services(?,?,?)",[$service_id,$hour_duration,$price_per_hour]);
    }

    /**
     * Funkcia prida novy servis do systemu
     *
     * @param $name
     * @param $type
     * @param $hour_duration
     * @param $price_per_hour
     * @return array
     */
    public function addService($name, $type,$hour_duration, $price_per_hour) {
        return DB::select("call create_service(?,?,?,?)",[$name,$type,$hour_duration,$price_per_hour]);
    }

}
