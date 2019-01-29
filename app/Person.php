<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    protected $table = 'person';

    public $timestamps = false;

    /**
     * Funkcia skontroluje ci uzivatel spravne zadal mesto
     *
     * @param $town_id
     * @param $town_name
     * @param $country_id
     * @return array
     */
    public function checkUserTown($town_id, $town_name, $country_id) {
        return DB::select("select check_town(?,?,?) as result",[$town_id, $town_name, $country_id]);
    }

    /**
     *Funkcia, ktora aktualizeje profil uzivatela
     *
     * @param $country_id
     * @param $psc
     * @param $town_name
     * @param $first_name
     * @param $last_name
     * @param $street
     * @param $orientation_no
     * @return array
     */
    public function updateUserProfile($country_id, $psc, $town_name, $first_name, $last_name, $street, $orientation_no){
        return DB::select("call update_customer(?, ?, ?, ?, ?, ?, ?, ?)",[$country_id, $town_name, $psc, $first_name, $last_name, $street, $orientation_no, Auth::user()->id]);
    }

    /**
     * Funkcia zistí či daná osoba v systéme už existuje
     *
     * @param $identification_no
     * @return mixed
     */
    public function checkExistingPerson($identification_no) {
        $result = Person::where('identification_no', $identification_no)->get();

        return $result;
    }

}
