<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetSessionUserId
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    // Chạy SAU KHI response đã gửi xong + session đã flush vào DB
    public function terminate(Request $request, $response): void
    {
        if (Auth::check()) {
            DB::table('sessions')
                ->where('id', $request->session()->getId())
                ->update(['user_id' => Auth::id()]);
        }
    }
}