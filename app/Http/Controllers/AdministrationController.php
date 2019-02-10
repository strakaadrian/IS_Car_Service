<?php

namespace App\Http\Controllers;


use App\CarService;
use App\Country;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        $service = new CarService;
        $countries = Country::all('country_id','country_name');

        if(Auth::user()->isAdmin()) {
            $car_service = $service->getEmpCarService(Auth::user()->id);
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
        $emp = new Employee;

        if(Auth::user()->isAdmin()) {
            $ico = $emp->getAdminCompany(Auth::user()->id);

            $employees = $emp->getEmployeeByIco($ico[0]->ico);
        } else {
            $employees =  $emp->getAllEmployees();
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

    /**
     * Funkcia, ktora aktualize udaje o zamestnancovi
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateEmployee() {
        $emp = new Employee;
        $service = new CarService;
        $countries = Country::all('country_id','country_name');


        if(Auth::user()->isAdmin()) {
            $ico = $emp->getAdminCompany(Auth::user()->id);

            $employees = $emp->getEmployeeByIco($ico[0]->ico);

            $car_service = $service->getEmpCarService(Auth::user()->id);
        } else {
            $employees =  $emp->getAllEmployees();

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

    /**
     *Funkcia, ktorá aktualizuje údaje o zamestnancovi / spravuje ju administrátor
     *
     *
     */
    public function updateEmployeeData(Request $request) {
        $employee = new Employee;
        $employee->updateEmployee($request->rc,$request->country_id, $request->psc, $request->town, $request->name, $request->surname, $request->street, $request->orientation_no, $request->position, $request->hour_start, $request->hour_end, $request->price_per_hour);

        return redirect('administration/update-employee');
    }

    /**
     * Funkcia, ktora vrati menu spravovania absencii
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function absence() {
        $emp = new Employee;

        if(Auth::user()->isAdmin()) {
            $ico = $emp->getAdminCompany(Auth::user()->id);

            $employees = $emp->getEmployeeByIco($ico[0]->ico);
        } else {
            $employees =  $emp->getAllEmployees();
        }
        return view('Administration/Absence/absence', compact('employees'));
    }

    /**
     * Funckia, ktora dotiahne zamestnancove absenice a nasledne zavola view kam ich vypise
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function employeeAbsence(Request $request) {
        $emp = new Employee;
        $emp_absence = $emp->getEmpAbsence($request->rc);

        $identification_no = $request->rc;

        $outputView =  view('Administration/Absence/absence-emp',compact('emp_absence','identification_no'))->render();
        return response()->json(['html'=>$outputView]);
    }




}
