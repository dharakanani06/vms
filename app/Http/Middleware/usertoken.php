<?php

namespace App\Http\Middleware;

use App\Models\LoginLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserToken
{
    public function handle(Request $request, Closure $next)
    {

        // Get the authorization header
        $token = $request->header('authorization');

        if (!$token) {
            return response()->json(['message' => 'Authorization header is missing'], 404);
        }

        // Remove 'Bearer ' prefix from the token
        $token = str_replace('Bearer ', '', $token);

        $request->headers->set('accept', 'application/json', true);

        // Check if token is valid
        $user = LoginLog::where('token', '=', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid API token'], 404);
        }

        // Add or modify data in the array
        $request->attributes->set('added_by', $user->id);
        $request->attributes->set('org_id', $user->org_id);

        return $next($request);
    }
}
