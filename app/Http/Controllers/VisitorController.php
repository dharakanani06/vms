<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    // Insert a Visitor
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|unique:visitors|max:255',
                'phone' => 'required|string|max:20',
                'gender' => 'required|string|max:10',
                'your_company' => 'required|string|max:100',
                'national_identification_no' => 'required|string|max:20',
                'address' => 'required|string',
                'select_employee' => 'required|exists:employees,id',
                'purpose_id' => 'required|exists:purpose,id',
                'visit_date' => 'required|date',
                'visitor_comefrom' => 'required|string|max:100',
                'status' => 'nullable|integer',
            ]);

            $validatedData['added_by'] = $request->attributes->get('added_by');
            $validatedData['org_id'] = $request->attributes->get('org_id');

            $visitor = Visitor::create($validatedData);

            return response()->json(['message' => 'Visitor created successfully', 'visitor' => $visitor], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating Visitor'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating Visitor'], 500);
        }

    }

    public function getdata(Request $request)
    {
        try {
            $visitors = Visitor::with(['purpose', 'employees'])->get();

            $responseData = $visitors->map(function ($visitor) {
                return [
                    'firstname' => $visitor->firstname,
                    'lastname' => $visitor->lastname,
                    'email' => $visitor->email,
                    'phone' => $visitor->phone,
                    'gender' => $visitor->gender,
                    'your_company' => $visitor->your_company,
                    'national_identification_no' => $visitor->national_identification_no,
                    'address' => $visitor->address,
                    'select_employee' => $visitor->employees,
                    'visit_date' => $visitor->visit_date,
                    'visitor_comefrom' => $visitor->visitor_comefrom,
                    'status' => $visitor->status,
                    'purpose_id' => $visitor->purpose,
                ];
            });

            return response()->json(['message' => 'Request successful', 'data' => $responseData], 200);

        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating visitor'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating visitor'], 500);

        }
    }

    // Update a Visitor
    public function update(Request $request, $id)
    {
        try {
            $visitor = Visitor::findOrFail($id);

            $validatedData = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|unique:visitors,email,' . $id . '|max:255',
                'phone' => 'required|string|max:20',
                'gender' => 'required|string|max:10',
                'your_company' => 'required|string|max:100',
                'national_identification_no' => 'required|string|max:20',
                'address' => 'required|string',
                'select_employee' => 'required|exists:employees,id',
                'purpose_id' => 'required|exists:purposes,id',
                'visit_date' => 'required|date',
                'visitor_comefrom' => 'required|string|max:100',
                'status' => 'nullable|integer',
            ]);

            $visitor->update($validatedData);

            return response()->json(['message' => 'Visitor updated successfully', 'visitor' => $visitor], 200);

        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating visitor'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating visitor'], 500);

        }
    }

    public function getSingleRow($id)
    {
        try {
            $visitor = Visitor::find($id);

            if ($visitor) {
                return response()->json(['message' => 'Row found', 'visitor' => $visitor], 200);
            } else {
                return response()->json(['message' => 'Row not found'], 404);
            }

        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating visitor'], 500);
            }
        }
    }

    // Delete a Visitor based on status code
    public function destroyByStatus($status, $id)
    {
        try {
            $visitor = Visitor::where('status', $status)->find($id);

            if (!$visitor) {
                return response()->json(['message' => 'Visitor not found with the specified status code and ID'], 404);
            }

            $visitor->delete();

            return response()->json(['message' => 'Visitor with ID ' . $id . ' and status code ' . $status . ' deleted successfully'], 200);

        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating visitor'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating visitor'], 500);

        }
    }
}
