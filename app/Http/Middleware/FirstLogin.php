<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
use Route;
class FirstLogin{
    public function handle($request, Closure $next)
    {
       
        if(Auth::user()->first_access=="0" && Route::getFacadeRoot()->current()->uri()!="/redefinirsenha"){
            
            return redirect('/redefinirsenha');
        }
        return $next($request);
    }
}
