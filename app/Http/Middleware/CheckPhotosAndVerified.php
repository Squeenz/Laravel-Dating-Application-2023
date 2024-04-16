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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Returns the authenticated user
        $user = Auth::user();

        if ($user->hasRole('pending verification'))
        {
            if (!$user->identity)
            {
                return redirect()->route('identity.create');
            }
            else if ($user->identity)
            {
                return redirect()->route('identity.index');
            }
        }
        //return the amount of photos the user has, if it's 0 and the user isn't currently in the route
        //we redirect them
        else if ($user->hasRole('user'))
        {
            if ($user->attributes()->count() === 0)
            {
                return redirect()->route('attributes.index');
            }
            else if ($user->preferences()->count() === 0)
            {
                return redirect()->route('preferences.index');
            }
            else if ($user->photos()->count() === 0)
            {
                return redirect()->route('photos.manage');
            }
        }

        return $next($request);
    }
}
