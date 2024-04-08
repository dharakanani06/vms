<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // Insert a department
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'department_name' => 'required|string',
                'status' => 'nullable|integer', // Assuming nullable as default is 0
            ]);

            $validatedData['added_by'] = $request->attributes->get('added_by');
            $validatedData['org_id'] = $request->attributes->get('org_id');

            $department = Department::create($validatedData);

            return response()->json(['message' => 'Department created successfully', 'department' => $department], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating Department'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Department'], 500);
        }
    }

    public function getdata(Request $request)
    {
        try {
            $departments = Department::all();
            return response()->json(['message' => 'Request successful', 'data' => $departments], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating Department'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Department'], 500);
        }
    }

    // Update a department
    public function update(Request $request, $id)
    {
        try {
            $department = Department::findOrFail($id);

            $validatedData = $request->validate([
                'department_name' => 'required|string',
                'status' => 'nullable|integer', // Assuming nullable as default is 0
            ]);

            $department->update($validatedData);

            return response()->json(['message' => 'Department updated successfully', 'department' => $department], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating Department'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Department'], 500);
        }
    }

    public function getupdate(Request $request, $id)
    {
        try {
            $department = Department::findOrFail($id);

            $validatedData = $request->validate([
                'department_name' => 'required|string',
            ]);

            $department->update($validatedData);

            return response()->json(['message' => 'Department updated successfully', 'department' => $department], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating Department'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Department'], 500);
        }
    }

    // Delete a department based on status code
    public function destroyByStatus($status, $id)
    {
        try {
            $department = Department::where('status', $status)->find($id);

            if (!$department) {
                return response()->json(['message' => 'Department not found with the specified status code and ID'], 404);
            }

            $department->delete();

            return response()->json(['message' => 'Department with ID ' . $id . ' and status code ' . $status . ' deleted successfully'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating Department'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Department'], 500);
        }
    }

    public function getSingleRow($id)
    {
        try {
            $row = Department::find($id);

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
                return response()->json(['message' => 'Error creating Department'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Department'], 500);
        }
    }
}
