<?php

namespace honeysec\Http\Middleware;

use Closure;

class RequireConsent
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
        $path = $request->route()->uri;
        $consented = $request->session()->get('consented', null);
        if($consented === null && $path !== "consent"){
            return redirect('/consent');
        }elseif($consented === false){
            return redirect('/ineligible');
        }else{
            return $next($request);
        }
    }
}
