<?php

namespace App\packages\Nova\Dashboard\src\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('nova-dashboard::dashboard');
    }
}