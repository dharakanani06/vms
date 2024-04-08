<?php

namespace App\Http\Controllers;

use App\Models\Purpose;
use Illuminate\Http\Request;

class PurposeController extends Controller
{
    // Insert a Purpose
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'status' => 'nullable|integer',
            ]);

            $validatedData['added_by'] = $request->attributes->get('added_by');
            $validatedData['org_id'] = $request->attributes->get('org_id');

            $purpose = Purpose::create($validatedData);

            return response()->json(['message' => 'Purpose created successfully', 'purpose' => $purpose], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating Purpose'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Purpose'], 500);
        }
    }
    public function getdata(Request $request)
    {
        $Purpose = Purpose::all();
        return response()->json(['message' => 'request successfull', 'data' => $Purpose], 200);
    }
    // Update a Visitor
    public function update(Request $request, $id)
    {
        try {
            $Purpose = Purpose::findOrFail($id);

            $validatedData = $request->validate([
                'title' => 'required|string',
                'added_by' => 'required|integer',
                'org_id' => 'required|integer',

            ]);

            $Purpose->update($validatedData);

            return response()->json(['message' => 'Purpose updated successfully', 'Purpose' => $Purpose], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating Purpose'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Purpose'], 500);
        }
    }

    // Delete an employee based on status code
    public function destroyByStatus($status, $id)
    {
        try {
            $Purpose = Purpose::where('status', $status)->find($id);

            if (!$Purpose) {
                return response()->json(['message' => 'Purpose not found with the specified status code and ID'], 404);
            }

            $Purpose->delete();

            return response()->json(['message' => 'Purpose with ID ' . $id . ' and status code ' . $status . ' deleted successfully'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating Purpose'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Purpose'], 500);
        }
    }
    public function getSingleRow($id)
    {
        try {
            $row = Purpose::find($id);

            if ($row) {
                return response()->json(['message' => 'Row found', 'row' => $row], 200);
            } else {
                return response()->json(['message' => 'Row not found'], 404);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating Purpose'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Purpose'], 500);
        }
    }
}
