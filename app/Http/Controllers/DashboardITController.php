<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardITController extends Controller
{
    public function index($data)
    {
        return view($data['url'], $data);
    }
}
