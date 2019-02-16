<?php

namespace App\Http\Controllers;

use App\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    /**
     * Funkcia zavola model Absence a funkciu deleteAbsence, ktora zmaze zamestnancovu absenciu
     *
     * @param Request $request
     */
    public function deleteEmployeeAbsence(Request $request) {
        $absence = new Absence;
        $absence->deleteAbsence($request->absence_id);
    }

    /**
     * Funkcia, ktora vytvori novy zaznam v tabulke Absence pre daneho zamestnanca
     *
     * @param Request $request
     */
    public function addAbsence(Request $request) {
        $absence = new Absence;
        $absence->addEmployeeAbsence($request->identification_no, $request->absence_from, $request->absence_to);
    }
}
