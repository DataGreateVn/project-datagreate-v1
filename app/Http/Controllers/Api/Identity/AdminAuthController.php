<?php

namespace App\Http\Controllers\Api\Identity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $r)
    {
        $r->validate(['email' => 'required|email', 'password' => 'required']);

        if (! Auth::guard('admin')->attempt($r->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        // abilities tuỳ chọn: ['admin:*'] hoặc để mảng rỗng []
        $token = $admin->createToken('admin-api', ['admin:*'])->plainTextToken;

        return response()->json(['token' => $token, 'admin' => $admin]);
    }

    public function me(Request $r)
    {
        return $r->user();
    }

    public function logout(Request $r)
    {
        $r->user()->currentAccessToken()?->delete();
        return response()->json(['ok' => true]);
    }
}
