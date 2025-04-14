<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Kaprodi
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login/pegawai');
        }      
        if (Auth::user()->role->role_name !== 'ketua_prodi') {
            return redirect('/unauthenticated');
        }
        
        return $next($request);
    }
}