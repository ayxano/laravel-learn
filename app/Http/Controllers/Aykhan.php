<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Aykhan extends Controller
{
    public function one() {
        return view('home.index');
    }

    public function two() {
        return view('home.contact');
    }
}
