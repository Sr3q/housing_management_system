<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function getAllContracts(string $housing_id)
    {
        try {
            $contracts = Contract::where('housing_id', $housing_id)->get();

            return $this->returnData('data', $contracts);
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }


    public function addContract(Request $request)
    {
        try {
            $request->validate([
                'housing_id' => 'required|exists:housing,id',
                'monthly_rent' => 'required|numeric',
                'owner_name' => 'nullable|string|max:255',
                'owner_representative' => 'nullable|string|max:255',
                'contact_number' => 'nullable|string|max:20',
                'note' => 'nullable|string',
                'start_date' => 'nullable|date',
                'expiry_date' => 'nullable|date|after_or_equal:start_date',
                'duration_of_contract' => 'nullable|string|max:100',
            ]);

            $contract = new Contract();
            $contract->monthly_rent = $request->monthly_rent;
            $contract->owner_name = $request->owner_name;
            $contract->owner_representative = $request->owner_representative;
            $contract->contact_number = $request->contact_number;
            $contract->note = $request->note;
            $contract->start_date = $request->start_date;
            $contract->expiry_date = $request->expiry_date;
            $contract->duration_of_contract = $request->duration_of_contract;
            $contract->housing_id = $request->housing_id;
            $contract->save();

            return $this->returnSuccessMessage("Contract added successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    //// to here


    /**
     * Update the specified resource in storage.
     */
    public function updateContract(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'housing_id' => 'required|exists:housing,id',
                'monthly_rent' => 'required|numeric',
                'owner_name' => 'nullable|string|max:255',
                'owner_representative' => 'nullable|string|max:255',
                'contact_number' => 'nullable|string|max:20',
                'note' => 'nullable|string',
                'start_date' => 'nullable|date',
                'expiry_date' => 'nullable|date|after_or_equal:start_date',
                'duration_of_contract' => 'nullable|string|max:100',
            ]);

            $contract = Contract::find($id);

            if (!$contract) {
                return $this->returnError(404, "Contract not found");
            }

            $contract->update($validatedData);

            return $this->returnSuccessMessage("Contract updated successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteContract(string $id)
    {
        try {

            $contract = Contract::find($id);

            if (!$contract) {
                return $this->returnError(404, "Contract not found");
            }

            $contract->delete();

            return $this->returnSuccessMessage("Contract deleted successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }
}
