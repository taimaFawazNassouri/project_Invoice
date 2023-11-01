<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()->status =='Enabled') {
            return response('this account no available');
        }
        // if (auth()->user() && auth()->user()->type != 'Owner')
        // {
        //     return redirect('/unauthorized');
        // }
        return $next($request);
    }
   
}
