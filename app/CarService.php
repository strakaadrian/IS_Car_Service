<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CarService extends Model
{
    protected $table = 'car_service';

    public $timestamps = false;

    /**
     * Funkcia, ktora mi vrati autoservis podla zadaneho ico
     *
     * @param $ico
     * @return mixed
     */
    public function getCarService($ico) {
        $result = CarService::where('ico', $ico)
                    ->join('town','town.town_id', '=', 'car_service.town_id')
                    ->select('town.town_name','car_service.service_name','car_service.street','car_service.orientation_no','car_service.phone_number','car_service.contact')
                    ->get();

        return $result;
    }

    /**
     * Funkcia vrati FIRMU, kde pracuje dany zamestnanec podla ID
     *
     * @param $id
     * @return mixed
     */
    public function getEmpCarService($id) {
        $car_service = Customer::where('customer.user_id', $id)
            ->join('person','person.identification_no', '=', 'customer.identification_no')
            ->join('employee', 'employee.identification_no', '=' , 'person.identification_no')
            ->join('car_service', 'employee.ico', '=', 'car_service.ico')
            ->pluck('car_service.service_name','car_service.ico');

        return $car_service;
    }

    /**
     * Funkcia dotiahne najlepsie zarabajuce firmy za posledny mesiac
     *
     * @return array
     */
    public function getBestEarningCompanies() {
        $totalEarnings = DB::select( DB::raw("select cs.service_name, SUM(r.work_hours*s.price_per_hour) as total_earnings from reservation r join services s on(s.service_id = r.service_id) join car_service cs on (r.ico = cs.ico) where DATE_FORMAT(r.repair_date,'%m-%Y') = DATE_FORMAT(sysdate(),'%m-%Y') group by cs.service_name order by total_earnings DESC LIMIT 5;"));

        return $totalEarnings;
    }



}
