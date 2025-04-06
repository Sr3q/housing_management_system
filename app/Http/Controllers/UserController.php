<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use GeneralTrait;

    ///////////////// admin ////////////////////////////
    public function getAllAdmins()
    {
        try {
            $admins = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->get();

            return $this->returnData('admins', $admins, 'Admins retrieved successfully.');

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

            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->save();

            $adminRole = Role::where('name', 'admin')->first();

            $user->roles()->attach($adminRole->id);

            return $this->returnSuccessMessage("Admin added successfully");

        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    public function deleteAdmin(string $id)
    {
        try {

            $admin = User::find($id);

            if (!$admin) {
                return $this->returnError(404, "Admin not found");
            }

            $admin->delete();

            return $this->returnSuccessMessage("Admin deleted successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }


    //////////////// housing officer ///////////////////////
    public function getAllHousingOfficers()
    {
        try {
            $housing_officers = User::whereHas('roles', function ($query) {
                $query->where('name', 'housing_officer');
            })->get();

            return $this->returnData('housing_officers', $housing_officers, 'Housing officers retrieved successfully.');

        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    public function addHousingOfficer(Request $request)
    {
        try {
            $request->validate([
                'company_id' => 'required|exists:companies,id',
                'name' => 'required',
                'username' => 'required|string|unique:users,username',
                'password' => 'required|min:8'
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->company_id = $request->company_id;
            $user->save();

            $adminRole = Role::where('name', 'housing_officer')->first();

            $user->roles()->attach($adminRole->id);

            return $this->returnSuccessMessage("Housing officer added successfully.");

        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    public function deleteHousingOfficer(string $id)
    {
        try {

            $housing_officer = User::find($id);

            if (!$housing_officer) {
                return $this->returnError(404, "Housing officer not found.");
            }

            $housing_officer->delete();

            return $this->returnSuccessMessage("Housing officer deleted successfully.");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }
}
