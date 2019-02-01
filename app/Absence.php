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

    public function addEmployeeAbsence($identification_no, $absence_from, $absence_to) {
        return DB::select("call add_absence(?, ?, ?) ",[$identification_no, $absence_from, $absence_to]);
    }

}
