<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;

class EspecialAccess
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
        if(auth()->user()->role->id == Role::DIRECTOR_GENERAL || auth()->user()->role->id == Role::DIRECTOR_LINEA || auth()->user()->role->id == Role::SUPERADMIN || auth()->user()->role->id == Role::SUPERVISOR)
            return $next($request);

        return redirect('/')->with('warning','Usted no tiene permiso para acceder a este modulo');
    }
}
