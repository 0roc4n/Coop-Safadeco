<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Check if user is authenticated and has role_id == 1 (admin)
        if (!$user || $user->role_id !== 1) {
            if($user->role_id === 2){
                return redirect()->route('teller.dashboard');
            }
            if($user->role_id === 3){
                return redirect()->route('accountant.dashboard');
            }
            if($user->role_id === 4){
                return redirect()->route('loanofficer.dashboard');
            }
            if($user->role_id === 5){
                return redirect()->route('clerk.dashboard');
            }
            if($user->role_id === 6){
                return redirect()->route('member.dashboard');
            }
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
