<?php

namespace App\Http\Controllers;

use App\CarBrand;
use App\CarPart;
use App\CarType;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Funkcia, ktorá nám dotiahne vsetky značky áut a otvori view produktov
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $car_brand = CarBrand::pluck('brand_name','brand_id');
        $car_type = CarType::pluck('car_type_name','car_type_id');
        $car_part = CarPart::pluck('part_name','car_part_id');

        return view('products',compact('car_brand','car_type','car_part'));
    }

    /**
     * Funkcia, ktora dotiahne modely aut na zaklade znacky
     *
     * @param Request $request
     */
    public function getCarModels(Request $request) {
        $car_type = CarType::where('brand_id',$request->car_brand)->get();

        echo json_encode($car_type);
        exit();
    }

    /**
     *Funkcia, ktorá dotiahne autosúčiastky na základe modelu auta
     *
     * @param Request $request
     */
    public function getCarParts(Request $request) {
        $car_parts = CarPart::where('car_type_id',$request->car_type)->get();

        echo json_encode($car_parts);
        exit();
    }
}
