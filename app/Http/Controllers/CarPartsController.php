<?php

namespace App\Http\Controllers;

use App\CarPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CarPartsController extends Controller
{
    /**
     * Funkcia vypise vsetky autosuciastky a ich mnozstva
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function watchCarParts() {
        $car_parts = DB::table('car_parts')
            ->join('car_type', 'car_type.car_type_id', '=', 'car_parts.car_type_id')
            ->join('car_brand', 'car_brand.brand_id', '=', 'car_type.brand_id')
            ->select('car_parts.car_part_id', 'car_parts.part_name', 'car_parts.stock', 'car_type.car_type_name', 'car_brand.brand_name')
            ->orderBy('car_brand.brand_name')
            ->orderBy('car_type.car_type_name')
            ->get();

        return view('Administration/CarParts/watch-car-parts', compact('car_parts'));
    }

    /**
     * Aktualizujem mnozstvo danej suciastky na sklade
     *
     * @param Request $request
     */
    public function updateCarParts(Request $request) {
        $car_part = new CarPart;
        $car_part->updateCarParts($request->car_part_id, $request->stock);

        return redirect()->back();
    }

    /**
     * Funkcia vrati mnozstvo suciastky na sklade
     *
     * @param Request $request
     */
    public function getCarPartStock(Request $request) {
        $stock = CarPart::where('car_part_id', $request->car_part_id)
            ->select('stock')
            ->get();

        echo json_encode($stock);
    }


}
