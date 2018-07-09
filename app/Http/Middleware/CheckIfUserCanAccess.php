<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfUserCanAccess
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
        if($request->has('id') && $request->id != Auth::id())
            return redirect('todos')->with('warning', 'Unauthorized operation');

        return $next($request);
    }
}
