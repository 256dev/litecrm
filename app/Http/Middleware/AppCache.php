<?php

namespace App\Http\Middleware;

use App\Models\AppSettings;
use Closure;
use Illuminate\Support\Facades\Auth;

class AppCache
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
        if (Auth::check()) {
            if (!session('currency') || !session('unitcode')) {
                $app_settins = AppSettings::find(1)->get()->first();
                session(['currency' => $app_settins->currency]);
                session(['unitcode' => $app_settins->unitcode]);
            }
        }
        return $next($request);
    }
}
