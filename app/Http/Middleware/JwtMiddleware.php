<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Token;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Utility\commonHelper;

class JwtMiddleware
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle(Request $request, Closure $next)
    {   
        $commonHelper = new commonHelper();
        $header = $request->header('Authorization');
        $checkTokenExist = $commonHelper->matchUserToken($header);
        
        if(empty($checkTokenExist)){
            return $this->error($commonHelper->constant(401));
        }
        
        Auth::loginUsingId($checkTokenExist->token_user_id);
        return $next($request);
    }
}
