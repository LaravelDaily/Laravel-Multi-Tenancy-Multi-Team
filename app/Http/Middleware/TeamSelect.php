<?php

namespace App\Http\Middleware;

use Closure;
use Gate;
use Illuminate\Support\Facades\Auth;

class TeamSelect
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
        // If user isn't guest or doesn't have team id stored do relevant actions
        if (
            Auth::guest() ||
            session()->has('team_id') ||
            request()->routeIs('admin.team-select.*') ||
            Gate::denies('team_select')
            ) {
            return $next($request);
        } else {
            // if user belongs only to one team store its id
            if (Auth::user()->teams->count() === 1) {
                session()->put('team_id', Auth::user()->teams->first()->id);
                return $next($request);
            }

            return redirect()->route('admin.team-select.select');
        }
    }
}
