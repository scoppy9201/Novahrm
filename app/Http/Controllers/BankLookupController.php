<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BankLookupController extends Controller
{
    // Lấy danh sách ngân hàng — cache 24h
    public function banks(): JsonResponse
    {
        $banks = Cache::remember('vietqr_banks', 86400, function () {
            $res = Http::get('https://api.vietqr.io/v2/banks');
            return $res->json('data', []);
        });

        return response()->json($banks);
    }

    // Tra cứu tên chủ tài khoản
    public function lookup(Request $request): JsonResponse
    {
        // Thử endpoint này
        $res = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api.vietqr.vn/v2/lookup', [
            'bin'           => $request->bin,
            'accountNumber' => $request->accountNumber,
            'transferType'  => 1,
            'transferAmount'=> 1000,
        ]);

        return response()->json([
            'http_status' => $res->status(),
            'body'        => $res->body(), // dùng body() thay vì json()
            'bin_received'=> $request->bin,
            'acc_received'=> $request->accountNumber,
        ]);
    }
}