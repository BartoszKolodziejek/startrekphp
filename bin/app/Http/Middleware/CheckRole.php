<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 05.06.2018
 * Time: 14:54
 */


namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (! $request->user()->hasRole($role)) {
            return redirect()->guest('/');
        }

        return $next($request);
    }

}