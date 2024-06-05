<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarSesionUsuario
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!session('usuario')){
            return redirect('/');
        }

        return $next($request);
    }
}
