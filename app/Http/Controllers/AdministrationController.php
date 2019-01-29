<?php

namespace App\Http\Controllers;

use App\CarService;
use App\Country;
use App\Customer;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdministrationController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Funkcia, ktorá nám vráti úvodný view do administratívy
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin-home');
    }

    /**
     * Funkcia, ktorá nám vratí pohlad s formulárom na pridávanie zamestnanca
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addEmployee() {
        $countries = Country::all('country_id','country_name');

        if(Auth::user()->isAdmin()) {
            $car_service = Customer::where('customer.user_id', Auth::user()->id)
                ->join('person','person.identification_no', '=', 'customer.identification_no')
                ->join('employee', 'employee.identification_no', '=' , 'person.identification_no')
                ->join('car_service', 'employee.ico', '=', 'car_service.ico')
                ->pluck('car_service.service_name','car_service.ico');
        } else {
            $car_service = CarService::pluck('service_name','ico');
        }
        return view('add-employee',compact('countries','car_service'));
    }

    /**
     *Funkcia, ktorá vytvorí zamestnanca
     */
    public function createEmployee(Request $request) {
        $employee = new Employee;
        $employee->createEmployee($request->country_id,$request->psc,$request->town, $request->rc, $request->name, $request->surname, $request->street, $request->orientation_no, $request->date_start, $request->ico, $request->position, $request->hour_start, $request->hour_end, $request->price_per_hour, $request->termination_date);

        return redirect('administration');
    }


    /**
     * Funckia, ktora dotiahne uzivatelov podla daneho servisu aby ich administrator mohol vyhodit
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEmployeeRc() {

        if(Auth::user()->isAdmin()) {
            $ico = Customer::where('customer.user_id', Auth::user()->id)
                ->join('person','person.identification_no', '=', 'customer.identification_no')
                ->join('employee', 'employee.identification_no', '=' , 'person.identification_no')
                ->select('employee.ico')
                ->get();

            $employees = Employee::where('ico',$ico[0]->ico)
                ->join('person','person.identification_no', '=', 'employee.identification_no')
                ->select('person.first_name', 'person.last_name', 'employee.identification_no')
                ->get();
        } else {
            $employees =  DB::table('employee')
                ->join('person','person.identification_no', '=', 'employee.identification_no')
                ->select('person.first_name', 'person.last_name', 'employee.identification_no')
                ->get();
        }

        return view('terminate-emp', compact('employees'));
    }


    /**
     * Funkcia, ktora nastavi termination_date zaestnancovi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function terminateEmployee(Request $request){
        $employee = new Employee;
        $employee->terminateEmployeeByRc($request->rc, $request->termination_date);

        return redirect('administration');
    }

    public function updateEmployee() {
        $countries = Country::all('country_id','country_name');

        if(Auth::user()->isAdmin()) {
            $ico = Customer::where('customer.user_id', Auth::user()->id)
                ->join('person','person.identification_no', '=', 'customer.identification_no')
                ->join('employee', 'employee.identification_no', '=' , 'person.identification_no')
                ->select('employee.ico')
                ->get();

            $employees = Employee::where('ico',$ico[0]->ico)
                ->join('person','person.identification_no', '=', 'employee.identification_no')
                ->select('person.first_name', 'person.last_name', 'employee.identification_no')
                ->get();

            $car_service = Customer::where('customer.user_id', Auth::user()->id)
                ->join('person','person.identification_no', '=', 'customer.identification_no')
                ->join('employee', 'employee.identification_no', '=' , 'person.identification_no')
                ->join('car_service', 'employee.ico', '=', 'car_service.ico')
                ->pluck('car_service.service_name','car_service.ico');
        } else {
            $employees =  DB::table('employee')
                ->join('person','person.identification_no', '=', 'employee.identification_no')
                ->select('person.first_name', 'person.last_name', 'employee.identification_no')
                ->get();

            $car_service = CarService::pluck('service_name','ico');
        }

        return view('update-employee', compact('employees','countries','car_service'));
    }

    /**
     * Funkcia, ktora dotiahne informacie o konkretnom zamestnancovi
     *
     * @param Request $request
     */
    public function getEmployeeData(Request $request) {
        $employee = new Employee;
        $result = $employee->getEmployeeDataByRC($request->rc);

        echo json_encode($result);
    }

}
