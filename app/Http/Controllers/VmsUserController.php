<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Models\VmsUsers;
use Hash;
use Illuminate\Http\Request;

class VmsUserController extends Controller
{

    public function create(Request $request)
    {

        try {

            // Return a view to create a new user
            $VmsUser = VmsUsers::create($request->all());
            return response()->json(['message' => 'User created successfully', 'data' => $VmsUser], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating User'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating User'], 500);
        }
    }
    public function getdata(Request $request)
    {
        try {
            $VmsUser = VmsUsers::all();
            return response()->json(['message' => 'request successfull', 'data' => $VmsUser], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating User'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating User'], 500);
        }

    }
    public function update(Request $request, $id)
    {
        try {
            // Find the users by ID
            $post = VmsUsers::find($id);
            $post->update($request->all());
            return response()->json(['message' => 'User update successfully', 'data' => $post], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating User'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating User'], 500);

        }
    }
    public function getupdate(Request $request, $id)
    {
        try {
            // Find the users by ID
            $get = VmsUsers::find($id);
            $get->update($request->all());
            return response()->json(['message' => 'User update successfully', 'data' => $get], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating User'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating User'], 500);

        }
    }
    public function getSingleRow($id)
    {
        try {
            $row = VmsUsers::find($id);

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
                return response()->json(['message' => 'Error creating User'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating User'], 500);

        }
    }
    // Delete an user based on status code
    public function destroyByStatus($status, $id)
    {
        try {
            $user = VmsUsers::where('status', $status)->find($id);

            if (!$user) {
                return response()->json(['message' => 'user not found with the specified status code and ID'], 404);
            }

            $user->delete();

            return response()->json(['message' => 'user with ID ' . $id . ' and status code ' . $status . ' deleted successfully'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating User'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating User'], 500);
        }

    }
    public function loginUser(Request $request)
    {

        // Validate the request (optional but recommended)
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Find the user by username
        $user = VmsUsers::where('username', $request->username)->select('username', 'mobile', 'id', 'org_id', 'password')->first();

        // Passwords match, user is authenticated
        if ($user && $request->password == $user->password) {
            // Construct response without including the password field
            $data = [
                'username' => $user->username,
                'mobile' => $user->mobile,
                'id' => $user->id,
                'org_id' => $user->org_id,
            ];

            $token = hash('sha256', json_encode($data));

            LoginLog::create([
                'user_id' => $user->id,
                'token' => $token,
                'org_id' => $user->org_id,
            ]);

            return response()->json([
                'message' => 'Login successfully',
                'data' => $data,
                'token' => $token,
            ], 200);
        } else {
            // Password is incorrect or user doesn't exist
            return response()->json(['message' => 'invalid user'], 403);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            if ($user) {
                $user->tokens()->delete();
                return response()->json(['message' => 'User logged out successfully'], 200);
            } else {
                return response()->json(['message' => 'User is not authenticated'], 401);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo;
            if ($errorCode[1] == 1062) { // MySQL error code for duplicate entry
                return response()->json(['message' => $errorCode[2]], 400);
            } else {
                return response()->json(['message' => 'Error creating User'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating User'], 500);
        }

    }
}
