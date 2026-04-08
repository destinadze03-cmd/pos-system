<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($role === 'admin') {
            // If the route requires admin but user is not admin
            if ($user->usertype !== 'admin') {
                return redirect()->route('dashboard')
                                 ->with('error', 'Access denied It can Only be accest by the Admin.');
            }
        }

        if ($role === 'cashier') {
            // If the route requires cashier but user is not cashier
            if ($user->usertype !== 'cashier') {
                return redirect()->route('dashboard')
                                 ->with('error', 'Access denied .');
            }
        }

        return $next($request);
    }
}