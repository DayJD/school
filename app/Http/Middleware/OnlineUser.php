<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class OnlineUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
  
        if (!empty(Auth::check())) {
           $expiretime = Carbon::now()->addMinutes(1);
           Cache::put('OnlineUer'. Auth::user()->id, true, $expiretime);

           $getUserInfo = User::getSingle(Auth::user()->id);
           $getUserInfo->updated_at = date('Y-m-d H:i:s');
           $getUserInfo->save();
        }
        return $next($request);
    }
}
