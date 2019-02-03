<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CarPart extends Model
{
    protected $table = 'car_parts';

    public $timestamps = false;

    /**
     * Funkcia aktualizuje mnozstvo tovaru na sklade
     *
     * @param $car_part_id
     * @param $stock
     * @return array
     */
    public function updateCarParts($car_part_id, $stock) {
        return DB::select("call update_car_parts(?, ?)",[$car_part_id,$stock]);
    }


}
