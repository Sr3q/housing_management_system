<?php

namespace App\Http\Controllers;

use App\Models\Housing;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class HousingController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function getAllHousing(string $company_id)
    {
        try {
            $housing = Housing::where('company_id', $company_id)->get();

            return $this->returnData('data', $housing);
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }


    public function addHousing(Request $request)
    {
        try {
            $request->validate([
                'company_id' => 'required|exists:companies,id',
                'name' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
                'ownership_type' => 'required|string|max:255',
                'type' => 'required|in:single,family',
                'status' => 'required|in:active,maintenance,inactive',
                'note' => 'nullable|string',
            ]);

            $housing = new Housing();
            $housing->name = $request->name;
            $housing->location = $request->location;
            $housing->ownership_type = $request->ownership_type;
            $housing->type = $request->type;
            $housing->status = $request->status;
            $housing->note = $request->note;
            $housing->company_id = $request->company_id;
            $housing->save();

            return $this->returnSuccessMessage("Housing added successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    //// to here


    /**
     * Update the specified resource in storage.
     */
    public function updateHousing(Request $request,string $id)
    {
        try {
            $validatedData = $request->validate([
                'company_id' => 'required|exists:companies,id',
                'name' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
                'ownership_type' => 'required|string|max:255',
                'type' => 'required|in:single,family',
                'status' => 'required|in:active,maintenance,inactive',
                'note' => 'nullable|string',
            ]);

            $housing = Housing::find($id);

            if (!$housing) {
                return $this->returnError(404, "Housing not found");
            }

            $housing->update($validatedData);

            return $this->returnSuccessMessage("Housing updated successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteHousing(string $id)
    {
        try {

            $housing = Housing::find($id);

            if (!$housing) {
                return $this->returnError(404, "Housing not found");
            }

            $housing->delete();

            return $this->returnSuccessMessage("Housing deleted successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }
}
