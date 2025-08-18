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
            abort(403, 'Unauthorized');
            return redirect('welcome')->with('error', 'You do not have permission to access this page.');
        }
        return $next($request);
    }
}
