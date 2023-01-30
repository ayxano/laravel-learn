<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheExampleController extends Controller
{
    public function get()
    {
        $value = Cache::get('personName');
        var_dump($value);

        // getting data from specific driver
        $value = Cache::store('redis')->get('personName', 'John');
        var_dump($value); 
    }

    public function set()
    {
        $put    = Cache::put('personName', 'Aykhan');
        var_dump($put);

        // setting data to specific driver
        $put    = Cache::store('redis')->put('personName', 'Ruslan');
        var_dump($put);
    }

    public function setTags()
    {
        Cache::tags(['people', 'artists'])->put('John', 'John Doe');
        Cache::tags(['people'])->put('John', 'John Brown');
    }

    public function getTags()
    {
        $john = Cache::tags(['people', 'artists'])->get('John');
        dd($john);
    }
}