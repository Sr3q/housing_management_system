<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HousingOfficerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // إذا لم يكن المستخدم مسجلاً الدخول، أرجع رد غير مصرح
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // تحقق مما إذا كان للمستخدم دور "housing_officer" أو "admin"
        if ($user->roles()->whereIn('name', ['housing_officer', 'admin'])->exists()) {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }
}
