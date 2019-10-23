<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;

class DirectorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->role->id == Role::DIRECTOR_GENERAL || auth()->user()->role->id == Role::DIRECTOR_LINEA || auth()->user()->role->id == Role::SUPERADMIN)
            return $next($request);
        return back()->with('warning','Usted no tiene los permisos requeridos para acceder a este modulo');
    }
}
