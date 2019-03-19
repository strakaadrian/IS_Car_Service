<?php

namespace App;

use Carbon\Carbon;
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

    /**
     * Funckia, ktora zavola proceduru a ta vytvori zamestnanca
     *
     * @param $country_id
     * @param $town_id
     * @param $town_name
     * @param $identification_no
     * @param $first_name
     * @param $last_name
     * @param $street
     * @param $orientation_no
     * @param $hire_date
     * @param $ico
     * @param $work_position
     * @param $hour_start
     * @param $hour_end
     * @param $price_per_hour
     * @param $termination_date
     * @return array
     */
    public function createEmployee($country_id, $town_id, $town_name, $identification_no, $first_name, $last_name, $street, $orientation_no, $hire_date, $ico, $work_position, $hour_start, $hour_end, $price_per_hour, $termination_date) {
        return DB::select("call create_employee(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$country_id,$town_id,$town_name,$identification_no,$first_name,$last_name,$street,$orientation_no,$hire_date,$ico,$work_position,$hour_start,$hour_end,$price_per_hour,$termination_date]);
    }

    /**
     *Funckia, ktorá vyhodi zamestnanca na zaklade idetification_no
     */
    public function terminateEmployeeByRc($identification_no, $termination_date) {
        return DB::select("call terminate_employee(?, ?)",[$identification_no,$termination_date]);
    }

    /**
     *Funkcia, ktora dotiahne informacie o uzivatelovi
     */
    public function getEmployeeDataByRC($rc) {
        $employee = Employee::where('employee.identification_no',$rc)
            ->join('person','person.identification_no', '=', 'employee.identification_no')
            ->join('town','town.town_id', '=', 'person.town_id')
            ->select('town.country_id','town.town_name', 'town.town_id', 'person.first_name','person.last_name', 'person.street','person.orientation_no','employee.work_position','employee.working_hour_start','employee.working_hour_end','employee.price_per_hour')
            ->get();

        return $employee;
    }

    /**
     *Funkcia, ktorá aktualizuje zamestnanca na základe identification_no
     */
    public function updateEmployee($identification_no, $country_id, $town_id, $town_name, $first_name, $last_name, $street, $orientation_no, $work_position, $working_hour_start, $working_hour_end, $price_per_hour) {
        return DB::select("call update_employee(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$identification_no,$country_id,$town_id,$town_name,$first_name,$last_name,$street,$orientation_no,$work_position,$working_hour_start,$working_hour_end,$price_per_hour]);
    }

    /**
     * Funkcia, ktorá vrati ICO firmy kde pracuje administrátor
     *
     * @param $id
     * @return mixed
     */
    public function getAdminCompany($id) {
        $ico = Customer::where('customer.user_id', $id)
            ->join('person','person.identification_no', '=', 'customer.identification_no')
            ->join('employee', 'employee.identification_no', '=' , 'person.identification_no')
            ->select('employee.ico')
            ->get();

        return $ico;
    }

    /**
     * Funkcia, ktorá vráti zamestnancov danej firmy na základe ICO
     *
     * @param $ico
     * @return mixed
     */
    public function getEmployeeByIco($ico) {
        $employees = Employee::where('ico',$ico)
            ->join('person','person.identification_no', '=', 'employee.identification_no')
            ->select('person.first_name', 'person.last_name', 'employee.identification_no')
            ->get();

        return $employees;
    }

    /**
     * Funckia vráti všetkych zamestnancov firiem
     *
     * @return mixed
     */
    public function getAllEmployees() {
        $employees =  DB::table('employee')
            ->join('person','person.identification_no', '=', 'employee.identification_no')
            ->select('person.first_name', 'person.last_name', 'employee.identification_no')
            ->get();

        return $employees;
    }

    /**
     * Funkcia dotiahne  id absencia a od kedy do kedy plati pre daneho uzivatela
     *
     * @param $rc
     * @return mixed
     */
    public function getEmpAbsence($rc) {
        $absence = DB::select( DB::raw("SELECT a.absence_id, a.absence_from, a.absence_to   FROM   absence a   JOIN   employee e ON (a.hire_date = e.hire_date AND e.ico = a.ico AND  a.identification_no = e.identification_no) WHERE   e.identification_no = ? AND (e.termination_date > sysdate() OR e.termination_date IS NULL)  AND (a.absence_to > sysdate() OR a.absence_to IS NULL)  ORDER BY absence_from"),  [$rc]);

        return $absence;
    }

}
