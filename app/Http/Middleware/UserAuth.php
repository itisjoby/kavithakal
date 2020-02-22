<?php

namespace App\Http\Middleware;

use Closure;

class UserAuth {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        // d(session()->all());
        if (!$request->session()->exists('session_id')) {
            return redirect('/login');
        }
        return $next($request);
    }

}
