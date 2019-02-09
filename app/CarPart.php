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

    /**
     * Funkcia skontroluje duplicitnu značku auta
     *
     * @param $brand_name
     * @return array
     */
    public function checkCarBrand($brand_name) {
        return DB::select("select check_car_brand(?) as result",[$brand_name]);
    }

    /**
     * Funkcia vytvori novy zaznam v tabulke car brand
     *
     * @param $car_brand
     * @return array
     */
    public function addNewCarBrand($car_brand) {
        return DB::select("call create_car_brand(?)",[$car_brand]);
    }

    /**
     * Funkcia skontroluje duplicitny model auta
     *
     * @param $brand_id
     * @param $car_type_name
     * @return array
     */
    public function checkCarTypeExists($brand_id, $car_type_name) {
        return DB::select("select check_car_type(?,?) as result",[$brand_id,$car_type_name]);
    }

    /**
     * Funkcia vytvori novy zaznam v tabulke car type
     *
     * @param $car_brand
     * @return array
     */
    public function addNewCarType($brand_id,$car_type_name) {
        return DB::select("call create_car_type(?,?)",[$brand_id,$car_type_name]);
    }

    /**
     * Funkcia vytvori novy zaznam v tabulke car parts
     *
     * @param $brand_id
     * @param $car_type_id
     * @param $part_name
     * @param $part_price
     * @param $stock
     * @param $image
     * @return array
     */
    public function addNewCarPart($car_type_id, $part_name, $part_price, $stock, $image) {
        return DB::select("call create_car_part(?,?,?,?,?)",[$car_type_id, $part_name,$part_price, $stock, $image]);
    }


    /**
     * Funkcia skontroluje duplicitnu autosuciastku
     *
     * @param $brand_id
     * @param $car_type_name
     * @return array
     */
    public function checkCarPartExists($car_type_id, $part_name) {
        return DB::select("select check_car_part(?,?) as result",[$car_type_id,$part_name]);
    }

    /**
     * Funckcia vrati najpredavanejsie suciastky podla znacky auta
     *
     * @param $car_type_id
     *
     * @return array
     */
    public function getBestCarPartsSales($car_type_id)
    {
        return DB::select("call  get_best_car_part_sales(?)", [$car_type_id]);
    }


}
