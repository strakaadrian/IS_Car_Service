<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerOrder;
use Illuminate\Support\Facades\Auth;
use PDF;
use Zend\Diactoros\Request;

class CustomerOrderController extends Controller
{
    public function index() {
        $customerOrders = new CustomerOrder;
        $orders = $customerOrders->getOrdersByUserId();

        return view('customer-order', compact('orders'));
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
}
