<?php

namespace App\Http\Controllers;

use App\Country;
use App\Customer;
use App\Person;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Funkcia skontroluje ci uzivatel zadal sprecne udaje o meste a state a rodne cislo
     *
     * @param Request $request
     */
    public function checkDataCustomer(Request $request) {
        $person = new Person;
        $customer = new Customer;

        $wrongLocation = $person->checkUserTown($request->town_id, $request->town_name, $request->country_id);
        $duplicateCustomer = $customer->duplicateCustomer($request->identification_no);

        if($wrongLocation[0]->result == 0) {
            echo json_encode('wrong_location');
            exit();
        } else if ($duplicateCustomer[0]->result == 1) {
            echo json_encode('duplicate_customer');
            exit();
        }

        echo json_encode('{}');
    }

    /**
     * Funkcia, dotiahne view pre pridanie zakaznika
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCustomer() {
        $countries = Country::all('country_id','country_name');

        return view('Administration/Customer/add-customer',compact('countries'));
    }

    /**
     *Funkcia vytvori noveho zakaznika
     */
    public function createCustomer(Request $request) {
        $customer = new Customer;
        $customer->addNewCustomer($request->country_id, $request->psc,$request->town, $request->rc,$request->name,  $request->surname, $request->street, $request->orientation_no);

        return redirect('administration');
    }

    /**
     *Funkcia skontroluje ci administrator zadal spravne udaje novemu zakaznikovi
     */
    public function checkData(Request $request) {
        $person = new Person;
        $customer = new Customer;
        $badTown = $person->checkUserTown($request->town_id, $request->town_name, $request->country_id);
        $duplicateCustomer = $customer->duplicateCustomer($request->rc);

        if($badTown[0]->result == 0) {
            echo json_encode('bad town');
            exit();
        } else if($duplicateCustomer[0]->result == 1) {
            echo json_encode('duplicate');
            exit();
        }

        echo json_encode('{}');
    }

    public function getNumberOfNewCustomers() {
        $resLabels = array();
        $resDataset = array();
        $chart = new SampleChart;

        foreach($result as $weekReservations) {
            array_push($resLabels,$weekReservations->repair_date);
            array_push($resDataset, $weekReservations->numb);
        }

        $chart->labels($resLabels);
        $chart->displayLegend(false);
        $chart->title('Počet rezervácii na najbližší týžden', $font_size = 14);
        $dataset = $chart->dataset('Počet rezervácii', 'bar', $resDataset);
        $dataset->backgroundColor(collect(['#003f5c','#374c80', '#7a5195','#bc5090','#ef5675','#ff764a','#ffa600']));
        $dataset->color(collect(['#003f5c','#374c80', '#7a5195','#bc5090','#ef5675','#ff764a','#ffa600']));


        return view('Administration/Graphs/next-week-reservations', compact('chart'));


    }



}
