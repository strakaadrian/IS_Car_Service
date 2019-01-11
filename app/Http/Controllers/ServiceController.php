<?php

namespace App\Http\Controllers;
use App\Service;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index() {
        $services = Service::all();

        return view('service',compact('services'));
    }

    /**
     * Funkcia prevezme ID a podla nej vypise udaje na objednanie sluzby
     * @return mixed
     */
    public function orderService($id) {

        $service = Service::where('service_id', $id)->get();

        return view('order-service', compact('service'));
    }

}
