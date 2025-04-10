<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class student
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) { // buat cek udh login atau belum
            return redirect()->route('login');
        }
        if (Auth::user()->role !== 'mahasiswa') {
            return redirect('/unauthenticated')->header('role', Auth::user()->role);
        } else {
            return $next($request);
        }
    }
}