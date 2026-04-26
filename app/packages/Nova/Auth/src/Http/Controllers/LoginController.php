<?php

namespace Nova\Auth\Http\Controllers;

use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return view('nova-auth::login');
    }
}