<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    use GeneralTrait;

    public function login(Request $request)
    {
        try {
            // التحقق من صحة البيانات الواردة
            $request->validate([
                'username' => 'required|string|exists:users,username',
                'password' => 'required'
            ]);

            // البحث عن المستخدم باستخدام اسم المستخدم
            $user = User::where('username', $request->username)->first();
            $user->load('roles');
            $user->load('company');

            // التحقق من صحة كلمة المرور
            if (!Hash::check($request->password, $user->password)) {
                return $this->returnError(400, "Wrong username or password!");
            }

            // إنشاء توكن جديد باستخدام Sanctum
            $token = $user->createToken($user->name)->plainTextToken;

            $user = UserResource::make($user, $token);

            // إعادة التوكن للمستخدم
            return $this->returnData('data', $user);
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }
}
