<?php

namespace App\Modules\Filex\Http\Middleware;

use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Routing\Middleware;

use Auth;
use Closure;
use Config;
use Flash;


class AuthenticateFilex implements Middleware
{


	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure                  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
//dd($request);

		if ( !Auth::user()->can('manage_filex') ) {
			Flash::error(trans('kotoba::auth.error.permission'));
			return new RedirectResponse(url(Config::get('kagi.auth_fail_redirect', '/')));
		}

		return $next($request);
	}


}
