<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function getAll(string $housing_id)
    {
        try {
            $attachment = Attachment::where('housing_id', $housing_id)->get();

            return $this->returnData('data', $attachment);
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }


    public function add(Request $request)
    {
        try {
            $request->validate([
                'housing_id' => 'required|exists:housing,id',
                'file' => 'required|file|max:20240', // 10MB max
            ]);

            $file = $request->file('file');
            $filePath = $file->store('attachments', 'public');

            $attachment = Attachment::create([
                'housing_id' => $request->housing_id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);

            return $this->returnSuccessMessage("Attachment added successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }

    //// to here


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:20240',
            ]);


            $attachment = Attachment::find($id);

            if (!$attachment) {
                return $this->returnError(404, "Attachment not found");
            }

            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }

            $file = $request->file('file');
            $filePath = $file->store('attachments', 'public');

            $attachment->update([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);

            return $this->returnSuccessMessage("Attachment updated successfully");
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

            $attachment = Attachment::find($id);

            if (!$attachment) {
                return $this->returnError(404, "Attachment not found");
            }

            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }

            $attachment->delete();

            return $this->returnSuccessMessage("Attachment deleted successfully");
        } catch (\Exception $ex) {
            return $this->returnError(500, $ex->getMessage());
        }
    }
}
