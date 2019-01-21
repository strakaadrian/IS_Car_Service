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
        $car_parts_by_model = collect([]);

        return view('products',compact('car_brand','car_type','car_part', 'car_parts_by_model'));
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

    /**
     *
     * Funkcia, ktorá nám dotiahne konkrétne autosúčiastky
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function getCarPartsForSale(Request $request) {
        if($request->all_parts == "true") {
            $car_parts_by_model = CarPart::where('car_type_id',$request->car_type_id)
                ->select('car_part_id','part_name','part_price','stock','image')
                ->get();
        } else {
            $car_parts_by_model = CarPart::where([
                ['car_type_id', '=', $request->car_type_id],
                ['car_part_id', '=', $request->car_part_id],
            ])->select('car_part_id','part_name','part_price','stock','image')
                ->get();
        }

        $outputView =  view('products-items',compact('car_parts_by_model'))->render();
        return response()->json(['html'=>$outputView]);
    }

}
