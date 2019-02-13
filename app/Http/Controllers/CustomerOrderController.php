<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use App\Customer;
use App\CustomerOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use Zend\Diactoros\Request;

class CustomerOrderController extends Controller
{
    public function index() {
        $customerOrders = new CustomerOrder;
        $orders = $customerOrders->getOrdersByUserId();

        return view('Customer/CustomerOrder/customer-order', compact('orders'));
    }

    /**
     * Funkcia, ktorá nám na základe order%id dotiahne všetky údaje potrebné na faktúru a potom ju zobrazí ako PDF
     *
     * @param $id
     * @return mixed
     */
    public function getOrderToPDF($id) {
        $customerOrder = new CustomerOrder;
        $sum = 0;

        $checkOrder = $customerOrder->checkOrderAuth($id);

        if($checkOrder->isEmpty()) {
            return redirect('orders');
        } else {
            $carParts = $customerOrder->getCarParts($id);
            $reservations = $customerOrder->getReservationsByOrderId($id);
            $person = $customerOrder->getPersonByOrderId();

            if(!$reservations->isEmpty()) {
                $sum += ($reservations[0]->price_per_hour * $reservations[0]->work_hours);
            }

            if(!$carParts->isEmpty()) {
                foreach($carParts as $carPart) {
                    $sum += ($carPart->part_price * $carPart->quantity);
                }
            }

            $pdf = PDF::loadView('invoice', compact('carParts','reservations', 'person', 'id','sum'));
            return $pdf->stream("invoice.pdf", array("Attachment" => false));
        }
    }

    public function getNumberOfOrders() {
        $resLabels = array();
        $resDataset = array();
        $chart = new SampleChart;
        $customerOrder = new CustomerOrder;

        $result = $customerOrder->getNumbOfOrders();

        foreach($result as $weekReservations) {
            array_push($resDataset, $weekReservations->numb);

            if($weekReservations->order_date == Carbon::now()->toDateString()) {
                array_push($resLabels, 'Dnes');
            } elseif($weekReservations->order_date == Carbon::yesterday()->toDateString()) {
                array_push($resLabels, 'Včera');
            } elseif($weekReservations->order_date == Carbon::now()->subDays(2)->toDateString()) {
                array_push($resLabels, 'Predvčerom');
            }
        }

        $chart->labels($resLabels);
        $chart->displayAxes(false);
        $chart->title('Počet objednávok', $font_size = 14);
        $dataset = $chart->dataset('Počet objednávok', 'pie', $resDataset);
        $dataset->backgroundColor(collect(['#003f5c','#bc5090','#ffa600']));
        $dataset->color(collect(['#003f5c','#bc5090','#ffa600']));


        return view('Administration/Graphs/number-of-orders',compact('chart'));
    }
}
