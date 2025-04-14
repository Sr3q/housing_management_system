<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function getAll(string $housing_id, string $flat_id)
    {
        try {
            $rooms = $housing_id != 'null' ? Room::where('housing_id', $housing_id)->get() :
                Room::where('flat_id', $flat_id)->get();

            return $this->returnData('data', $rooms);
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }


    public function add(Request $request)
    {
        try {
            $request->validate([
                'housing_id' => 'nullable|exists:housing,id',
                'flat_id' => 'nullable|exists:flats,id',
                'room_number' => 'required|string',
                'capacity' => 'required|integer|min:1',
                'status' => 'required|in:vacant,occupied,maintenance',
                'type' => 'required|in:living,storehouse,bathroom,kitchen,laundry',
            ]);

            $room = new Room();
            $room->housing_id = $request->housing_id;
            $room->flat_id = $request->flat_id;
            $room->room_number = $request->room_number;
            $room->capacity = $request->capacity;
            $room->status = $request->status;
            $room->type = $request->type;
            $room->save();

            return $this->returnSuccessMessage("Room added successfully");
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
                'housing_id' => 'nullable|exists:housing,id',
                'flat_id' => 'nullable|exists:flats,id',
                'room_number' => 'required|string',
                'capacity' => 'required|integer|min:1',
                'status' => 'required|in:vacant,occupied,maintenance',
                'type' => 'required|in:living,storehouse,bathroom,kitchen,laundry',
            ]);

            $room = Room::find($id);

            if (!$room) {
                return $this->returnError(404, "Room not found");
            }

            $room->update($validatedData);

            return $this->returnSuccessMessage("Room updated successfully");
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

            $room = Room::find($id);

            if (!$room) {
                return $this->returnError(404, "Room not found");
            }

            $room->delete();

            return $this->returnSuccessMessage("Room deleted successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }
}
