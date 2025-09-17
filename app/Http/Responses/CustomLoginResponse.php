<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();
        // dd($user); // Debugging line to inspect the user object

        // Example: redirect based on role column
        if ($user->role_id === '1' || $user->role_id === '3' || $user->role_id === '4') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'manager') {
            return redirect()->route('manager.dashboard');
        }

        // return redirect()->route('')->with('error', 'You do not have permission to access this page.');
    }
}
