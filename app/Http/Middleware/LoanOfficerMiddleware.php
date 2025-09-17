<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanOfficerMiddleware
{
	/**
	 * Handle an incoming request.
	 */
	public function handle(Request $request, Closure $next)
	{
		$user = Auth::user();

		// Allow only authenticated users with role_id == 4 (loan officer)
		if (!$user || $user->role_id !== 4) {
			return redirect('/')->with('error', 'You do not have permission to access this page.');
		}

		return $next($request);
	}
}


