<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna terautentikasi dan memiliki role yang tidak diizinkan
        if (Auth::check() && in_array(Auth::user()->role, ['administration', 'homeroom_teacher', 'staff_student', 'headmaster'])) {
            // Redirect ke halaman yang sesuai berdasarkan role
            switch (Auth::user()->role) {
                case 'administration':
                    return redirect()->route('administration.dashboard'); // Route Staff IT
                case 'homeroom_teacher':
                    return redirect()->route('homeroom-teacher.dashboard'); // Route Homeroom Teacher
                case 'staff_student':
                    return redirect()->route('staff-student.dashboard'); // Route Staff Student
                    case 'headmaster':
                    return redirect()->route('headmaster.dashboard'); // Route Headmaster
                default:
                    return redirect()->route('landing-page'); // Fallback
            }
        }
        return $next($request);
    }
}
