<?php

namespace App\Http\Controllers;

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
}
