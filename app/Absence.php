<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Absence extends Model
{
    protected $table = 'absence';

    public $timestamps = false;


    /**
     * Funkcia zmaze zamestnancovu absenciu
     *
     * @param $absence_id
     * @return mixed
     */
    public function deleteAbsence($absence_id) {
        return DB::select("call delete_from_absence(?) ",[$absence_id]);
    }

    /**
     * Funkcia prida zamestnancovi novu absenciu na dany datum
     *
     * @param $identification_no
     * @param $absence_from
     * @param $absence_to
     * @return array
     */
    public function addEmployeeAbsence($identification_no, $absence_from, $absence_to) {
        return DB::select("call add_absence(?, ?, ?) ",[$identification_no, $absence_from, $absence_to]);
    }

}
