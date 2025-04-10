<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Student
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login/mahasiswa');
        }
        
        if (Auth::user()->role->role_name !== 'mahasiswa') {
            return redirect('/unauthenticated');
        }
        
        return $next($request);
    }
}