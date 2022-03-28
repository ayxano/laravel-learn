<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke()
    {
        return 'This is a single action controller. You don\'t  need to speficy function name on routes';
    }
}
