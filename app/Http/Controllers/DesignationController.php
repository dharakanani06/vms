<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    // Insert a designation
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'designation_name' => 'required|string',
                'status' => 'nullable|integer',
            ]);

            $validatedData['added_by'] = $request->attributes->get('added_by');
            $validatedData['org_id'] = $request->attributes->get('org_id');

            $designation = Designation::create($validatedData);

            return response()->json(['message' => 'Designation created successfully', 'designation' => $designation], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating employee'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating employee'], 500);
        }
    }

    public function getdata(Request $request)
    {
        try {
            $employee = Designation::all();
            return response()->json(['message' => 'request successfull', 'data' => $employee], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating employee'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating employee'], 500);
        }
    }
    // Update a designation
    public function update(Request $request, $id)
    {
        try {
            $designation = Designation::findOrFail($id);

            $validatedData = $request->validate([
                'designation_name' => 'required|string',
                'added_by' => 'required|integer',
                'org_id' => 'required|integer',

            ]);

            $designation->update($validatedData);

            return response()->json(['message' => 'Designation updated successfully', 'designation' => $designation], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating employee'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating employee'], 500);
        }
    }
    public function getupdate(Request $request, $id)
    {
        try {
            $designation = Designation::findOrFail($id);

            $validatedData = $request->validate([
                'designation_name' => 'required|string',
                'added_by' => 'required|integer',
                'org_id' => 'required|integer',

            ]);

            $designation->update($validatedData);

            return response()->json(['message' => 'Designation updated successfully', 'designation' => $designation], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating employee'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating employee'], 500);
        }
    }
    public function getSingleRow($id)
    {
        try {
            $row = Designation::find($id);

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
                return response()->json(['message' => 'Error creating employee'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating employee'], 500);
        }
    }
    // Delete an Designation based on status code
    public function destroyByStatus($status, $id)
    {
        try {
            $Designation = Designation::where('status', $status)->find($id);

            if (!$Designation) {
                return response()->json(['message' => 'Designation not found with the specified status code and ID'], 404);
            }

            $Designation->delete();

            return response()->json(['message' => 'Designation with ID ' . $id . ' and status code ' . $status . ' deleted successfully'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating employee'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating employee'], 500);
        }
    }

}
