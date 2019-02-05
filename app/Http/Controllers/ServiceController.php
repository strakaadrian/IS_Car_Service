<?php

namespace App\Http\Controllers;

use App\CarService;
use App\Country;
use App\Customer;
use App\Employee;
use App\Person;
use App\Reservation;
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
        $car_services = CarService::pluck('service_name','ico');
        $service = Service::where('service_id', $id)->get();

        return view('order-service', compact('service','countries','car_services','id'));
    }

    /**
     * Funkcia ktorá nám na základe formulára vytvorí zákazníka
     */
    public function createCustomer(Request $request){
        $customer = new Customer;
        $customer->dataInsertCustomer($request->psc, $request->country_id, $request->town, $request->rc, $request->name, $request->surname, $request->street, $request->orientation_no);

        return back();
    }


    /**
     * funkcia ktora nam skontroluje vstupi od uzivatela, ci moze pridat rezervaciu
     *
     * @param Request $request
     */
    public function checkInsertReservCond(Request $request) {
        $employee = new Employee;
        $service = new Service;
        $reservation = new Reservation;

        $empExists = $employee->dataGetEmpByWorkPos($request->ico,$request->id);
        $correctDate = $service->checkDay($request->date);
        $absence = $employee->dataCheckEmpAbs($request->ico,$request->id,$request->date);
        $work_time = $employee->checkEmpWorkTime($request->ico, $request->id, $request->hour);
        $reserved = $reservation->checkReservationAtTime($request->ico, $request->date, $request->hour);

        if($empExists[0]->result == 0) {
            echo json_encode('bad emp');
            exit();
        } else if ($correctDate[0]->result == 'wrong day') {
            echo json_encode('wrong day');
            exit();
        } else if ($correctDate[0]->result == 'weekend') {
            echo json_encode('weekend');
            exit();
        } else if ($correctDate[0]->result == 'too far') {
            echo json_encode('too far');
            exit();
        } else if ($absence[0]->result == 1) {
            echo json_encode('absence');
            exit();
        } else if ($work_time[0]->result == 1) {
            echo json_encode('work time');
            exit();
        } else if ($reserved[0]->result == 1) {
            echo json_encode('reserved');
            exit();
        }

        echo json_encode('{}');
    }


    /**
     * Funkcia nam vlozi zaznam do rezervacie na zaklade vyplneneho formulara
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insertReservation(Request $request) {
        $reservation = new Reservation;
        $reservation->dataInsertReservation($request->car_service,$request->id,$request->date,$request->hour);
        return redirect('home');
    }


    /**
     * Funkcia vytvori pohlad pre spravu services
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminServices() {

        $services = Service::all('service_id','name','hour_duration','price_per_hour');

        return view('Administration/Services/admin-services', compact('services'));
    }

    /**
     * Vrati pocet hodin a cenu prace pre dany service id
     *
     * @param Request $request
     */
    public function getServiceHours(Request $request) {
        $services = Service::where('service_id', $request->service_update_id)
            ->select('hour_duration','price_per_hour')
            ->get();

        echo json_encode($services);
    }

    /**
     * Funkcia updatne tabulku services podla ID
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateServices(Request $request) {
        $service = new Service;
        $service->updateServicesByID($request->service_update, $request->hour_duration, $request->price_per_hour);

        return redirect()->back();
    }

    /**
     * Funkcia, ktora zobrazi view na pridanie sluzby
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addService() {
        return view('Administration/Services/add-service');
    }


}
