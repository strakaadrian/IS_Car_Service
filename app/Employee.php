<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    protected $table = 'employee';

    public $timestamps = false;


    /**
     * funnkcia nam vrati zamesnanca firmy podla work_position , ktora sa nachadza v services tabulke
     *
     * @param $ico
     * @param $id
     * @return array
     */
    public function dataGetEmpByWorkPos($ico,$id){
        return DB::select("select get_employee(?, ?) as result",[$ico,$id]);
    }

    /**
     * Funkcia, ktora vrati, ci dany employer v dany den nema absenciu
     *
     * @param $ico
     * @param $id
     * @param $date
     */
    public function dataCheckEmpAbs($ico, $id, $date) {
        return DB::select("select get_absence(?, ?, ?) as result",[$ico,$id,$date]);
    }

    /**
     * Funkcia ktora zisti ci dany pracovnik pracuje v dobu kedy sa zakaznik chce objednat
     *
     * @param $ico
     * @param $id
     * @param $order_hour
     * @return array
     */
    public function checkEmpWorkTime($ico, $id, $order_hour) {
        return DB::select("select get_employee_work_time(?, ?, ?) as result",[$ico,$id,$order_hour]);
    }
    
}
