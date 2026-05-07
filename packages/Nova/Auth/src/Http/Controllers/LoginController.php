<?php

namespace Nova\Auth\Http\Controllers;

use Nova\Auth\Http\Requests\LoginRequest;
use Nova\Auth\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginService $service
    ) {}

    public function index()
    {
        return view('nova-auth::login');
    }

    public function store(LoginRequest $request)
    {
        $this->service->checkThrottle($request);
        $this->service->attempt($request);
        $this->service->persistSession($request);

        return redirect()->intended('/dashboard')
            ->with('login_success', true);
    }

    public function destroy(Request $request)
    {
        $this->service->logout($request);

        return redirect()->route('login')
            ->with('logout_success', true);
    }
}