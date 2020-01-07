<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;

class AnalistAccess
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
        if(auth()->user()->role->id == Role::ANALISTA_VACACIONES || auth()->user()->role->id == Role::ANALISTA_PERMISOS)
            return $next($request);

        return redirect(route('home'))->with('warning','Usted no tiene los permisos requeridos para acceder a este modulo');
    }
}
