<?php

namespace App\Http\Controllers;

use App\Country;
use App\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Tato funckia nam vypise profil
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {

        $customer = DB::table('customer')
            ->join('person', 'person.identification_no', '=', 'customer.identification_no')
            ->join('town', 'town.town_id', '=', 'person.town_id')
            ->join('country', 'country.country_id', '=', 'town.country_id')
            ->select('country.country_id', 'country.country_name', 'town.town_id','town.town_name', 'person.first_name', 'person.last_name', 'person.street', 'person.orientation_no')
            ->where([
                ['customer.user_id', '=', Auth::user()->id],
            ])
            ->get();

        $countries = Country::all('country_id','country_name');

        return view('Customer/Profile/profile', compact('customer','countries'));
    }

    /**
     * Funkcia skontroluje ci uzivatel zadal sprecne udaje o meste a state
     *
     * @param Request $request
     */
    public function checkDataProfile(Request $request) {
        $person = new Person;
        $result = $person->checkUserTown($request->town_id, $request->town_name, $request->country_id);
        echo json_encode($result);
    }


    public function updateProfile(Request $request) {
        $person = new Person;
        $person->updateUserProfile($request->country_id, $request->town, $request->psc, $request->name, $request->surname, $request->street, $request->orientation_no);
        return redirect('home');
    }
}
