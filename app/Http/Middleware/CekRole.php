<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->user()->hasAnyRole($roles)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}