<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StateController extends Controller
{
    public function index()
    {
        return State::all();
    }
}
