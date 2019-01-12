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
     * @param $id
     * @return array
     */
    public function dataGetEmpByWorkPos($id){
        return DB::select('select hire_date,ico,identification_no from employee where work_position in (select type from services where service_id = ?)',[$id]);
    }
    
    
}
