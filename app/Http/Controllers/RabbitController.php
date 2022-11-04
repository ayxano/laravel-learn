<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use Illuminate\Http\Request;

class RabbitController extends Controller
{
    public function sendEvent() {
        $json = [
            'time'  => date('Y-m-d H:i:s'),
            'uniq'  => uniqid()
        ];
        TestJob::dispatch($json);
    }


}
