<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPhotosAndVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Returns the authenticated user
        $user = Auth::user();

        if ($user->hasRole('pending verification'))
        {
            if (!$user->identity)
            {
                return redirect(route('identity.create'));
            }
            else
            {
                return redirect(route('identity.index'));
            }
        }
        //return the amount of photos the user has, if it's 0 and the user isn't currently in the route
        //we redirect them
        else if ($user->hasPhotos->count() == 0 && !$request->is('photos.create'))
        {
            return redirect(route('photos.create'));
        }
        else
        {
            return $next($request);
        }
    }
}
