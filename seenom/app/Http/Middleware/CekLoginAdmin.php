<?php

namespace App\Http\Middleware;

use Closure;

class CekLoginAdmin
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
        $sesi = $request->session()->get('izin');
        if($sesi == "tidak" || $sesi == null) {
          return redirect('login');
        }

        return $next($request);
    }
}
