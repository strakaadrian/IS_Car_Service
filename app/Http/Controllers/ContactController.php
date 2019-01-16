<?php

namespace App\Http\Controllers;

use App\CarService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     *Funkcia ktorá nam zobrazí okno kontakt
     */
    public function index() {
        $car_services = CarService::pluck('service_name','ico');

        return view('contact',compact('car_services'));
    }

    /**
     * Funkcia, ktora nam na zaklade ico dotiahne autoservis a vratiho ho ako json ajaxu
     *
     * @param Request $request
     */
    public function getCarServiceByIco(Request $request) {
        $carService = new CarService;
        $result = $carService->getCarService($request->ico);
        echo json_encode($result);
    }
}
