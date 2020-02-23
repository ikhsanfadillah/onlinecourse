<?php

namespace App\Http\Middleware;

use App\UserLesson;
use Closure;
use Illuminate\Support\Facades\Auth;

class CanWatchLesson
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
        $hasLesson = UserLesson::where('user_id',Auth::id())->where('lesson_id',$request->lesson)->first();
        if ($hasLesson
            || Auth::user()->hasRole(['super-admin','admin', 'mentor','staff','student']))
            return $next($request);
        abort(403, 'Unauthorized action.');
    }
    
}
