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

    /**
     * Funkcia, ktora aktualizuje NULL datum v absence_to zamestnanca
     *
     * @param $absence_id
     * @param $absence_date
     * @return array
     */
    public function updateEmpAbsence($absence_id, $absence_date) {
        return DB::select("call update_absence(?, ?) ",[$absence_id, $absence_date]);
    }
}
