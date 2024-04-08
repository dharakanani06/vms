<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Insert an employee
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'gender' => 'required|in:male,female',
                'phone_number' => 'required|string',
                'address' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'date_of_birth' => 'required|date',
                'role' => 'required|string',
                'departments_id' => 'required|exists:departments,id', // Ensure departments_id exists in departments table
                'designations_id' => 'required|exists:designations,id', // Ensure designations_id exists in designations table
                'image' => 'nullable', // Assuming image is optional and max size is 2MB

            ]);

            // Handle image upload if present
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('employee_images');
                $validatedData['image'] = $imagePath;
            }

            $validatedData['added_by'] = $request->attributes->get('added_by');
            $validatedData['org_id'] = $request->attributes->get('org_id');

            $employee = Employee::create($validatedData);

            $this->add_log(json_encode(['message' => 'Employee created successfully', 'employee' => $employee]), $validatedData['ADDED_BY'], $validatedData['ORG_ID']);

            return response()->json(['message' => 'Employee created successfully', 'employee' => $employee], 201);
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

    public function add_log($logData, $orgId, $addedBy)
    {
        $data = [
            'ORG_ID' => $orgId,
            'ADDED_BY' => $addedBy,
            'LOG' => $logData,
        ];

        Logs::create($data);
        return response()->json(['message' => 'request successfull', 'data' => $data], 200);

    }
    public function getdata(Request $request)
    {
        try {
            // Retrieve all employees with their department and designation information
            $employee = Employee::with(['departments' => function ($query) {
                $query->select('id', 'department_name');
            }, 'designations' => function ($query) {
                $query->select('id', 'designation_name');
            }])->get();
            $responseData = $employee->map(function ($employee) {
                return [
                    'name' => $employee->name,
                    'email' => $employee->email,
                    'gender' => $employee->gender,
                    'phone_number' => $employee->phone_number,
                    'address' => $employee->address,
                    'country' => $employee->country,
                    'city' => $employee->city,
                    'state' => $employee->state,
                    'date_of_birth' => $employee->date_of_birth,
                    'role' => $employee->role,
                    'department_name' => $employee->departments,
                    'designation_name' => $employee->designations,
                    'image' => $employee->image,

                ];
            });
            return response()->json(['message' => 'request successfull', 'data' => $responseData], 200);
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

    // Update an employee
    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'gender' => 'required|in:male,female',
                'phone_number' => 'required|string',
                'address' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'date_of_birth' => 'required|date',
                'role' => 'required|string',
                'image' => 'nullable', // Assuming image is optional and max size is 2MB
                // 'org_id' => 'required|integer',
                // 'added_by' => 'required|integer',
            ]);

            // Handle image upload if present
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('employee_images');
                $validatedData['image'] = $imagePath;
            }

            $employee->update($validatedData);

            return response()->json(['message' => 'Employee updated successfully', 'employee' => $employee], 200);
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
            $employee = Employee::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'gender' => 'required|in:male,female',
                'phone_number' => 'required|string',
                'address' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'date_of_birth' => 'required|date',
                'role' => 'required|string',
                'image' => 'nullable', // Assuming image is optional and max size is 2MB
                'org_id' => 'required|integer',
                'added_by' => 'required|integer',
            ]);
            // Handle image upload if present
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('employee_images');
                $validatedData['image'] = $imagePath;
            }

            $employee->update($validatedData);

            return response()->json(['message' => 'Employee updated successfully', 'employee' => $employee], 200);
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

    // Delete an employee based on status code
    public function destroyByStatus($status, $id)
    {
        try {
            $employee = Employee::where('status', $status)->find($id);

            if (!$employee) {
                return response()->json(['message' => 'Employee not found with the specified status code and ID'], 404);
            }

            $employee->delete();

            return response()->json(['message' => 'Employee with ID ' . $id . ' and status code ' . $status . ' deleted successfully'], 200);
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
            $row = Employee::find($id);

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
}
