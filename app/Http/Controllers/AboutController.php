<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Funkcia dotiahne z databazy 10 servisov na ukazku ake ponukame a vrati view "about"
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $services = Service::all()->take(10);

        return view('Customer/About/about', compact('services'));
    }
}
