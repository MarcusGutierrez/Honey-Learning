<?php

namespace honeysec\Http\Middleware;

use Closure;

class RequireGameSession
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
        $user_id = $request->session()->get('user_id', null);
        $session_id = $request->session()->get('session_id', null);
        if($user_id == null || $session_id == null){
            $request->session()->flash('message', 'A game session must be initiated to perform this action');
            return redirect('/home');
        }
        return $next($request);
    }
}
