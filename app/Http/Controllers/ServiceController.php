<?php

namespace App\Http\Controllers;

use App\CarService;
use App\Country;
use App\Customer;
use App\Employee;
use App\Person;
use App\Service;
use App\Town;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Funkcia, ktora nam dotiahne vsetky sluzby, ktore su a posle nam ich do view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $services = Service::all();

        return view('service',compact('services'));
    }

    /**
     * Funkcia prevezme ID a podla nej vypise udaje na objednanie sluzby
     * @return mixed
     */
    public function orderService($id) {
        $countries = Country::all('country_id','country_name');
        $car_services = CarService::all('ico','service_name');
        $service = Service::where('service_id', $id)->get();

        return view('order-service', compact('service','countries','car_services','id'));
    }

    /**
     * Funkcia ktorá nám na základe formulára vytvorí zákazníka
     */
    public function createCustomer(Request $request){
        $town = new Town;
        if(!$town->existTown($request->psc)) {
            $town->town_id = $request->psc;
            $town->country_id = $request->country_id;
            $town->town_name = $request->town;
            $town->save();
        }

        $person = new Person;
        $person->identification_no = $request->rc;
        $person->town_id = $request->psc;
        $person->first_name = $request->name;
        $person->last_name = $request->surname;
        $person->street = $request->street;
        $person->orientation_no = $request->orientation_no;
        $person->save();

        $customer = new Customer;
        $customer->identification_no = $request->rc;
        $customer->user_id = Auth::user()->id;
        $customer->save();

        header("Location: {$_SERVER['HTTP_REFERER']}");
        die();
    }


    /**
     * funkcia ktora nam skontroluje vstupi od uzivatela, ci moze pridat rezervaciu
     *
     * @param Request $request
     */
    public function checkInsertConditions(Request $request) {
        $employee = new Employee;
        $service = new Service;

        $empExists = $employee->dataGetEmpByWorkPos($request->ico,$request->id);
        $correctDate = $service->checkDay($request->date);
        $absence = $employee->dataCheckEmpAbs($request->ico,$request->id,$request->date);

        if($empExists[0]->result == 0) {
            echo json_encode('bad emp');
            exit();
        } else if ($correctDate[0]->result == 'wrong day') {
            echo json_encode('wrong day');
            exit();
        } else if ($correctDate[0]->result == 'weekend') {
            echo json_encode('weekend');
            exit();
        } else if ($absence[0]->result == 1) {
            echo json_encode('absence');
            exit();
        }
    }

}
