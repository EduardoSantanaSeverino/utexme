<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRolesAndPerms
{
	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
	public function checkRolesAndPerms($request, Closure $next, $guard = null)
	{
		if(env('NOT_ROLES_AND_PERMS', false))
		{
			return $next($request);
		}

		$actions = $request->route()->getAction();

		if(isset($actions['roles']))
		{
			if($request->user() === null)
			{
				return response()->view('errors.401', [], 401);
			}
			$roles = $actions['roles'];
			if($request->user()->hasAnyRole($roles) || !$roles)
			{
				return $next($request);
			}
		}
		elseif (isset($actions['perms']))
		{
			if($request->user() === null)
			{
				return response()->view('errors.401', [], 401);
			}
			$perms = $actions['perms'];
			if($request->user()->hasAnyPerm($perms) || !$perms)
			{
				return $next($request);
			}
		}
		else
		{
			return $next($request);
		}

		return response()->view('errors.401', [], 401);
	}
}
