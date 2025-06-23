<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user(); // atau auth()->user()

        // Kalau belum login
        if (!$user) {
            return redirect()->route('login')->with('danger', 'Mohon login dahulu'); // bisa juga abort(401) kalau pakai API
        }

        // Kalau role user tidak cocok
        if (!in_array($user->role->value, $roles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
