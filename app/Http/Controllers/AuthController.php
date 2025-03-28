<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // التحقق من صحة البيانات الواردة
        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        // البحث عن المستخدم باستخدام اسم المستخدم
        $user = User::where('username', $request->username)->first();

        // التحقق من صحة كلمة المرور
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'بيانات الاعتماد غير صحيحة'
            ], 401);
        }

        // إنشاء توكن جديد باستخدام Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // إعادة التوكن للمستخدم
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }
}
