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
        // dd($sesi);
        if($sesi == "tidak") {
          return redirect('login');
          // dd('raoleh');
        }

        // if($sesi == 'tidak') {
        //   $request->session()->flush();
        //   return redirect('admin/login');
        // }
        return $next($request);
    }
}
