<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    /**
     * taha data z tabulky Customer
     * @var string
     */
    protected $table = 'customer';

    public $timestamps = false;

    /**
     * Procedura ktora nam vytvori customera
     *
     * @param $psc
     * @param $country_id
     * @param $town_name
     * @param $identification_no
     * @param $first_name
     * @param $last_name
     * @param $street
     * @param $orientation_no
     * @return mixed
     */
    public function dataInsertCustomer($psc, $country_id, $town_name, $identification_no, $first_name, $last_name, $street, $orientation_no) {
        return DB::select("call create_customer(?, ?, ?, ?, ?, ?, ?, ?, ?)",[$psc,$country_id,$town_name, $identification_no, $first_name, $last_name, $street, $orientation_no, Auth::user()->id]);
    }

}
