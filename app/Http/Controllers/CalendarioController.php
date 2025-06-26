<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    /**
     * Display the calendar view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backoffice.calendario.index');
    }
}
