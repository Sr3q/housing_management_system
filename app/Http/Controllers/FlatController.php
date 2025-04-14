<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class FlatController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function getAll(string $housing_id)
    {
        try {
            $flats = Flat::where('housing_id', $housing_id)->get();

            return $this->returnData('data', $flats);
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }


    public function add(Request $request)
    {
        try {
            $request->validate([
                'housing_id' => 'required|exists:housing,id',
                'flat_number' => 'required|string|max:255',
                'area' => 'nullable|numeric|min:0',
                'number_of_bathrooms' => 'required|integer|min:0',
                'kitchen' => 'required|boolean',
                'status' => 'required|in:vacant,occupied,maintenance',
            ]);

            $flat = new Flat();
            $flat->housing_id = $request->housing_id;
            $flat->flat_number = $request->flat_number;
            $flat->area = $request->area;
            $flat->number_of_bathrooms = $request->number_of_bathrooms;
            $flat->kitchen = $request->kitchen;
            $flat->status = $request->status;
            $flat->save();

            return $this->returnSuccessMessage("Flat added successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    //// to here


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'housing_id' => 'required|exists:housing,id',
                'flat_number' => 'required|string|max:255',
                'area' => 'nullable|numeric|min:0',
                'number_of_bathrooms' => 'required|integer|min:0',
                'kitchen' => 'required|boolean',
                'status' => 'required|in:vacant,occupied,maintenance',
            ]);

            $flat = Flat::find($id);

            if (!$flat) {
                return $this->returnError(404, "Flat not found");
            }

            $flat->update($validatedData);

            return $this->returnSuccessMessage("Flat updated successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {

            $flat = Flat::find($id);

            if (!$flat) {
                return $this->returnError(404, "Flat not found");
            }

            $flat->delete();

            return $this->returnSuccessMessage("Flat deleted successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }
}
