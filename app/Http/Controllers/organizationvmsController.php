<?php

namespace App\Http\Controllers;

use App\Models\organization_vms;
use Illuminate\Http\Request;

class organizationvmsController extends Controller
{
    public function create(Request $request)
    {
        try {
            $VmsUser = organization_vms::create($request->all());
            return response()->json(['message' => 'User created successfully', 'data' => $VmsUser], 201);

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

    public function getdata(Request $request)
    {
        try {
            $VmsUser = organization_vms::all();
            return response()->json(['message' => 'request successfull', 'data' => $VmsUser], 200);

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

    public function update(Request $request, $id)
    {
        try {
            // Find the organization by ID
            $post = organization_vms::find($id);

            if (!$post) {
                return response()->json(['message' => 'User not found'], 404);
            }
            // Update the organization with the request data
            $post->update($request->all());
            return response()->json(['message' => 'User update successfully', 'data' => $post], 201);

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
    public function getupdate(Request $request, $id)
    {
        try {
            // Find the organization by ID
            $get = organization_vms::find($id);

            if (!$get) {
                return response()->json(['message' => 'User not found'], 404);
            }
            // Update the organization with the request data
            $get->update($request->all());
            return response()->json(['message' => 'User update successfully', 'data' => $get], 201);

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
            $row = organization_vms::find($id);

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
                return response()->json(['message' => 'Error creating visitor'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating visitor'], 500);

        }
    }

    // Delete an employee based on status code
    public function destroyByStatus($status, $id)
    {
        try {
            $organization = organization_vms::where('status', $status)->find($id);

            if (!$organization) {
                return response()->json(['message' => 'organization not found with the specified status code and ID'], 404);
            }

            $organization->delete();

            return response()->json(['message' => 'organization with ID ' . $id . ' and status code ' . $status . ' deleted successfully'], 200);

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
