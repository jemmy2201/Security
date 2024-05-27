<?php

namespace App\Http\Middleware;

use Closure;
use App\Maintenan;

class maintenance
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
        $data = Maintenan::first();
        if (!empty($data) && $data->maintenace_flag){
            return response(view('maintenance'));
        }
        return $next($request);
    }
}
