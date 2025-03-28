<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the admin role
        $user = $request->user();

        if (!$user || !$user->roles->contains('name', 'admin')) {
            return $this->returnError(403,'Forbidden');
        }

        return $next($request);
    }
}
