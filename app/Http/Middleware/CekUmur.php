<?php

namespace App\Http\Middleware;

use Closure;
use http\Client\Curl\User;

class CekUmur
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
        // url = "www.asd.com/mentors/1"
        $user = User::find($request->id);


        return $next($request);
    }
}
