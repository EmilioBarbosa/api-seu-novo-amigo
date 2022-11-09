<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CityController extends Controller
{
    public function index()
    {
        return City::all();
    }
}
