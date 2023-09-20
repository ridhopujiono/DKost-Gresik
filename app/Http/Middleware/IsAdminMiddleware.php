<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset(auth()->user()->level)) {
            if (!auth()->user()->level == 'admin') {
                return redirect('/')->with('error', 'Maaf, Anda harus login terlebih dahulu');
            }
        } else {
            return redirect('/')->with('error', 'Maaf, Anda harus login terlebih dahulu');
        }

        return $next($request);
    }
}
