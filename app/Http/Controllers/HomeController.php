<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class HomeController extends Controller
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
     * Funkcia zobrazi uvodny VIEW
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Customer/Home/home');
    }
}
