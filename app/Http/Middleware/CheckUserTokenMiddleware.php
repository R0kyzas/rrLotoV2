<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckUserTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userToken = json_decode($request->cookie('userToken'), true);

        if (is_null($userToken)) {
            do {
                $token = Str::uuid()->toString();
            } while (Order::where("token", "=", $token)->first());

            return $next($request)->withCookie(cookie('userToken', json_encode($token), Carbon::now()->addYear()->timestamp));
        }

        return $next($request);
    }
}
