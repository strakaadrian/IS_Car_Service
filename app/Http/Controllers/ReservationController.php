<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use App\Employee;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{


    /**
     * Funkcia dotiahne rezervacie prihlaseneho usera a vypise ich do pohladu
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $reserModel = new Reservation;

        $reserv = $reserModel->getReservations();

        return view('reservation', compact('reserv','reserModel'));
    }

    /**
     * Funkcia, ktorá odstráni z tabuľky reservations záznam podľa reservation_id
     *
     * @param Request $request
     *
     */
    public function deleteFromReservations(Request $request) {
        $reserModel = new Reservation;
        $reserModel->deleteFromReservationsById($request->reservation_id);
    }

    /**
     * Funkcia dotiahne  udaje o rezervaciach
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminReservations() {
        $res = new  Reservation;
        $emp = new Employee;

        if(Auth::user()->isAdmin()) {
            $ico = $emp->getAdminCompany(Auth::user()->id);
            $reservations = $res->getAdminReservations($ico[0]->ico);
        } else {
            $reservations = $res->getAdminAllReservations();
        }
        return view('Administration/Customer/admin-reservation',compact('reservations'));
    }

    /**
     * Zmaze rezervaciu
     *
     * @param Request $request
     *
     */
    public function deleteReservation(Request $request) {
        $res = new  Reservation;
        $res->deleteFromReservationsById($request->reservation_id);
    }

    public function getWorkHours(Request $request) {
        $result = Reservation::where('reservation_id',$request->reservation_id)
            ->select('work_hours')
            ->get();

        echo json_encode($result);
    }

    /**
     * Funkcia, ktora zrealizuje rezervaciu a nastavy objednavku na zrealizovana
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function realizeReservation(Request $request) {
        $res = new  Reservation;
        $res->updateReservationById($request->reservation_id, $request->work_hours);

        return redirect()->back();
    }

    /**
     * Funckcia zobrazi graf rezervacii na najblizsich 7 dni
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getWeekReservations() {
        $emp = new Employee;
        $weekRes = new Reservation;
        $resLabels = array();
        $resDataset = array();
        $chart = new SampleChart;

        if(Auth::user()->isAdmin()) {
            $ico = $emp->getAdminCompany(Auth::user()->id);

            $result = $weekRes->getWeekReservationsByIco($ico[0]->ico);
        } else {
            $result = $weekRes->getWeekReservations();
        }

        foreach($result as $weekReservations) {
            array_push($resLabels,$weekReservations->repair_date);
            array_push($resDataset, $weekReservations->numb);
        }

        $chart->labels($resLabels);
        $chart->displayLegend(false);
        $chart->title('Počet rezervácii na najbližší týžden', $font_size = 14);
        $dataset = $chart->dataset('Počet rezervácii', 'bar', $resDataset);
        $dataset->backgroundColor(collect(['#003f5c','#374c80', '#7a5195','#bc5090','#ef5675','#ff764a','#ffa600']));
        $dataset->color(collect(['#003f5c','#374c80', '#7a5195','#bc5090','#ef5675','#ff764a','#ffa600']));


        return view('Administration/Graphs/next-week-reservations', compact('chart'));
    }

}
