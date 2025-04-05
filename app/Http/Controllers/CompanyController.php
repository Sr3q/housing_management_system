<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function getAllCompanies()
    {
        try {
            $companies = Company::withCount('housing')
                ->withSum('housing as total_capacity', 'building_capacity')
                ->with(['users' => function ($query) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('name', 'housing_officer');
                    });
                }])
                ->get();

            return $this->returnData('data',$companies);
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }


    public function addCompany(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
            ]);

            $company = new Company();
            $company->name = $request->name;
            $company->location = $request->location;
            $company->save();

            return $this->returnSuccessMessage("company added successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateCompany(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name'     => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
            ]);

            $company = Company::find($request->company_id);

            if(!$company){
                return $this->returnError(404,"Company not found");
            }

            $company->update($validatedData);

            return $this->returnSuccessMessage("company updated successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteCompany(string $id)
    {
        try {

            $company = Company::find($id);

            if(!$company){
                return $this->returnError(404,"Company not found");
            }

            $company->delete();

            return $this->returnSuccessMessage("company deleted successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }
}
