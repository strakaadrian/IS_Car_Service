<?php

namespace App\Http\Controllers;

use App\CarBrand;
use App\CarPart;
use App\CarType;
use App\Charts\SampleChart;
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


    /**
     * Funkcia vrati pohlad na spravovanie autodielov
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function administrateCarParts() {
        $car_brands = CarBrand::pluck('brand_name','brand_id');
        $car_type = CarType::pluck('car_type_name','car_type_id');

        return view('Administration/CarParts/administrate-car-parts',compact('car_brands','car_type'));
    }

    /**
     * Funkcia skontroluje duplicitne zadanu znacku auta
     *
     * @param Request $request
     */
    public function checkCarBrandByName(Request $request) {
        $car_part = new CarPart;
        $brand = $car_part->checkCarBrand($request->brand_name);

        if($brand[0]->result == 1) {
            echo json_encode('duplicate');
            exit();
        } else {
            echo json_encode('');
            exit();
        }
    }

    /**
     * Funkcia vytvori novy zaznam v tabulke car brand
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCarBrand(Request $request) {
        $car_part = new CarPart;
        $car_part->addNewCarBrand($request->car_brand);

        return redirect()->back();
    }

    /**
     * Funkcia skontroluje duplicitne zadany model auta
     *
     * @param Request $request
     */
    public function checkCarType(Request $request) {
        $car_part = new CarPart;
        $carType = $car_part->checkCarTypeExists($request->brand_id,$request->car_type_name);

        if($carType[0]->result == 1) {
            echo json_encode('duplicate');
            exit();
        } else {
            echo json_encode('');
            exit();
        }
    }

    /**
     * Funkcia vytvori novy zaznam v tabulke car type
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCarType(Request $request) {
        $car_part = new CarPart;
        $car_part->addNewCarType($request->car_brand_select,$request->car_type_add);

        return redirect()->back();
    }


    /**
     * Funkcia dotiahne modely aut na zaklade značky
     *
     * @param Request $request
     */
    public function getCarTypes(Request $request) {
        $car_type = CarType::where('brand_id',$request->car_brand_parts)->get();

        echo json_encode($car_type);
        exit();
    }

    /**
     * Funkcia vytvori zaznam v tabulke car parts a ak obrazok este nieje na disku tak ho na disk prida inak nie
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addCarPart(Request $request) {
        $car_part = new CarPart;

        $this->validate($request, [
            'image' => 'mimes:jpeg,png,bmp,tiff | max:4096',
        ]);

        if ($request->file('image')->isValid()){
            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $image = 'parts/' . $name;

            if(CarPart::where('image','/parts' . $name)->exists()) {
                $car_part->addNewCarPart($request->car_type_parts, $request->car_part_name, $request->part_price, $request->stock, $image);

                return redirect()->back();
            } else {
                $storage_path = storage_path('app/public/parts');
                $file->move($storage_path , $name);
                $car_part->addNewCarPart($request->car_type_parts, $request->car_part_name, $request->part_price, $request->stock, $image);

                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    /**
     *Funkcia skontroluje existenciu zaznamu v tabulke car parts
     */
    public function checkCarPart(Request $request) {
        $car_part = new CarPart;
        $carPart = $car_part->checkCarPartExists($request->car_type_parts,$request->car_part_name);

        if($carPart[0]->result == 1) {
            echo json_encode('duplicate');
            exit();
        } else {
            echo json_encode('');
            exit();
        }
    }

    /**
     * Funckia zobrazi view s grafom podla daneho modelu auta
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bestCarPartsSales() {
        $car_brand = CarBrand::pluck('brand_name','brand_id');
        $car_type = CarType::pluck('car_type_name','car_type_id');

        return view('Administration/Graphs/best-car-parts-sales',compact('car_brand','car_type'));
    }

    /**
     * Funckia vrati graf pre najpredavanejsie autosuciastky
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getBestSalesGraph(Request $request) {
        $car_brand = CarBrand::pluck('brand_name','brand_id');
        $car_type = CarType::pluck('car_type_name','car_type_id');
        $carParts = new CarPart;
        $resLabels = array();
        $resDataset = array();
        $chart = new SampleChart;

        $result = $carParts->getBestCarPartsSales($request->car_type_graph);

        foreach($result as $bestCarParts) {
            array_push($resLabels,$bestCarParts->part_name);
            array_push($resDataset, $bestCarParts->quantity);
        }

        $chart->labels($resLabels);
        $chart->displayLegend(false);
        $chart->title('Najviac predávané autosúčiastky', $font_size = 14);
        $dataset = $chart->dataset('Predaných', 'bar', $resDataset);
        $dataset->backgroundColor(collect(['#003f5c','#374c80', '#7a5195','#bc5090','#ef5675','#ff764a','#ffa600']));
        $dataset->color(collect(['#003f5c','#374c80', '#7a5195','#bc5090','#ef5675','#ff764a','#ffa600']));

        return view('Administration/Graphs/best-car-parts-sales-graph', compact('chart','car_brand','car_type'));
    }

}
