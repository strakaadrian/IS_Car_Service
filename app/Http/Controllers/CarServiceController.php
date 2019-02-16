<?php

namespace App\Http\Controllers;

use App\CarService;
use App\Charts\SampleChart;

class CarServiceController extends Controller
{
    /**
     * Funkcia dotiahne GRAF pre  najlepsie zarabajuce firmy za posledny mesiac
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bestMonthEarnings() {
        $carService = new CarService;
        $resLabels = array();
        $resDataset = array();
        $chart = new SampleChart;

        $result = $carService->getBestEarningCompanies();

        foreach($result as $weekReservations) {
            array_push($resLabels,$weekReservations->service_name);
            array_push($resDataset, $weekReservations->total_earnings);
        }

        $chart->labels($resLabels);
        $chart->displayLegend(false);
        $chart->title('Najlepšie zarabajúce firmy', $font_size = 14);
        $dataset = $chart->dataset('Zárobok', 'bar', $resDataset);
        $dataset->backgroundColor(collect(['#003f5c','#bc5090','#ef5675','#ff764a','#ffa600']));
        $dataset->color(collect(['#003f5c','#bc5090','#ef5675','#ff764a','#ffa600']));

        return view('Administration/Graphs/best-month-earnings',compact('chart'));
    }
}
