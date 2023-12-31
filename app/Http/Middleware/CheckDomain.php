<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDomain
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
        if(!in_array($request->getHost(), ['localhost', '192.168.0.2'])){
        // if($request->getHost()!='localhost'){
            return response()->json([
                'status' => false,
                'message' => 'Akses Tidak Diperbolehkan'
            ]);
        }
        return $next($request);
    }
}
