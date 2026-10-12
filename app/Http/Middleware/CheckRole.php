<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Pemakaian di route: ->middleware('role:admin') atau ->middleware('role:admin,editor')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        if (!$user->hasRole(...$roles)) {
            abort(403, 'Kamu tidak punya akses ke halaman ini.');
        }

        return $next($request);
    }
}
