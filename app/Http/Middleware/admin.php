<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class admin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) { // buat cek udh login atau belum
            return redirect('/login/pegawai');
        }
        if (Auth::user()->role->role_name !== 'admin') {
            return redirect('/unauthenticated');
        } 
        
        return $next($request);
        
    }
}