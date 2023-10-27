<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class IpMiddleware
{ 
    public $whiteIps = ['127.0.0.1','::1', '39.41.186.163','182.191.91.183','203.175.79.117','39.32.63.172', '39.41.158.99','39.50.54.108','39.50.42.51','39.41.211.38','39.32.212.203','182.182.204.141','37.111.130.99','37.111.128.111','85.194.243.137','39.50.75.0','182.182.245.134','39.32.219.237','39.32.219.237','39.41.200.114','39.50.41.25','39.50.76.134','37.111.137.148','82.131.99.12','39.32.119.121','39.50.25.98','39.32.79.215','37.111.137.118','82.131.69.80','39.50.108.40','39.50.46.193','85.194.243.243','39.50.103.193','82.131.55.178','37.111.137.196','202.69.12.132','39.32.148.44','37.111.137.166','39.50.33.132','39.50.93.241'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       // if (!in_array($request->ip(), $this->whiteIps)) {
        //     if (!Auth::guard('customer')->check()) {
                
         
        //     return response()->json(['Site is under development please contact administartor on developer@carish.ee.Thanks']);
        // }

        return $next($request);
    }
}