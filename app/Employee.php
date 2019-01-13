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
    
    
}
