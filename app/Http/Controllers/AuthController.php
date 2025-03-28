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

    public function addAdmin(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required|string|unique:users,username',
                'password' => 'required|min:8'
            ]);

            $user=new User();
            $user->name=$request->name;
            $user->username=$request->username;
            $user->password=Hash::make($request->password);
            $user->save();

            $adminRole = Role::where('name', 'admin')->first();

            $user->roles()->attach($adminRole->id);

            return $this->returnSuccessMessage("Admin added successfully");

        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }
}
