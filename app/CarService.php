<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarService extends Model
{
    protected $table = 'car_service';

    public $timestamps = false;

    /**
     * Funkcia, ktora mi vrati autoservis podla zadaneho ico
     *
     * @param $ico
     * @return mixed
     */
    public function getCarService($ico) {
        $result = CarService::where('ico', $ico)
                    ->join('town','town.town_id', '=', 'car_service.town_id')
                    ->select('town.town_name','car_service.service_name','car_service.street','car_service.orientation_no','car_service.phone_number','car_service.contact')
                    ->get();

        return $result;
    }
}
