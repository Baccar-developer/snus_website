<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;

class AuthMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        
        if(Auth::check()){
            return $next($request);
        }
        else{
            $tocken = Cookie::get('user_tocken');
            $user = User::where("remember_token" , $tocken)->first();
            if($user){
                Auth::login($user);
                return $next($request);
            }
            else{
                return redirect("/login")->with("msg", Auth::user()->customer_name);
            }
        }
        
    }
}
