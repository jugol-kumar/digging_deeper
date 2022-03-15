<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::check() && Auth::user()->role->slug == 'admin'){
            return $next($request);
        }elseif(Auth::check() && Auth::user()->role->slug == 'user'){
            return redirect(route('user.profile'))->with('message', 'You Can not access admin area');
        }else{
            return redirect('/login')->with('message', 'You Can not access admin area');
        }

    }
}
