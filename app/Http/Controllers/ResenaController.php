<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResenaController extends Controller
{
     public function index()
    {
        return view('cliente.resenia.index'); // o el nombre que uses para la vista
    }
}
