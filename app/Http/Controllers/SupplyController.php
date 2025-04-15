<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplyController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function getAll(string $company_id)
    {
        try {
            $supplies = Supply::where('company_id', $company_id)->get();

            return $this->returnData('data', $supplies);
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }


    public function add(Request $request)
    {
        try {
            $request->validate([
                'company_id' => 'required|exists:companies,id',
                'name' => 'required|string|max:255',
                'expiry_date' => 'required|date|after:today',
                'image' => 'nullable|file|max:20240',
            ]);

            $data = [
                'company_id' => $request->company_id,
                'name' => $request->name,
                'expiry_date' => $request->expiry_date,
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('supplies', 'public');
                $data['image_path'] = $imagePath;
            }

            Supply::Create($data);

            return $this->returnSuccessMessage("Supply added successfully");
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
            $request->validate([
                'name' => 'required|string|max:255',
                'expiry_date' => 'required|date|after:today',
                'image' => 'nullable|file|max:20240',
            ]);

            $supply = Supply::find($id);

            if (!$supply) {
                return $this->returnError(404, "Supply not found");
            }

            $data = [
                'name' => $request->name,
                'expiry_date' => $request->expiry_date,
            ];

            if ($request->hasFile('image')) {
                if ($supply->image_path) {
                    if (Storage::disk('public')->exists($supply->image_path)) {
                        Storage::disk('public')->delete($supply->image_path);
                    }
                }
                $image = $request->file('image');
                $imagePath = $image->store('supplies', 'public');
                $data['image_path'] = $imagePath;
            }

            $supply->update($data);

            return $this->returnSuccessMessage("Supply updated successfully");
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

            $supply = Supply::find($id);

            if (!$supply) {
                return $this->returnError(404, "Supply not found");
            }

            if ($supply->image_path) {
                if (Storage::disk('public')->exists($supply->image_path)) {
                    Storage::disk('public')->delete($supply->image_path);
                }

                $supply->update([
                    'image_path' => null,
                ]);
            }

            $supply->delete();

            return $this->returnSuccessMessage("Supply deleted successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    public function deleteImage(string $id)
    {
        try {

            $supply = Supply::find($id);

            if (!$supply) {
                return $this->returnError(404, "Supply not found");
            }

            if ($supply->image_path) {
                if (Storage::disk('public')->exists($supply->image_path)) {
                    Storage::disk('public')->delete($supply->image_path);
                }
            }

            $supply->update([
                'image_path' => null,
            ]);

            return $this->returnSuccessMessage("Supply image deleted successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }
}
