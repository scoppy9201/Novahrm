<?php

namespace Nova\Core\Http\Controllers;

use Nova\Core\Models\DemoRegistration;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DemoRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => 'required|string|max:20',
            'company_name' => 'required|string|max:255',
            'product'      => 'nullable|string',
            'position'     => 'nullable|string',
            'city'         => 'nullable|string',
            'company_size' => 'nullable|string',
        ]);

        DemoRegistration::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký thành công! Chúng tôi sẽ liên hệ bạn sớm nhất.'
        ]);
    }
}