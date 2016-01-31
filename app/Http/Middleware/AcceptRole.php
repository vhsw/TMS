<?php namespace App\Http\Middleware;

use Auth;
use App\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class AcceptRole
{
	protected $auth;

	/**
	 * Creates a new instance of the middleware.
	 *
	 * @param Guard $auth
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  Closure $next
	 * @param  $roles
	 * @return mixed
	 */
	public function handle($request, Closure $next, $roles)
	{

		if ($this->auth->guest() || !$request->user()->hasRole($roles) ) {
			return redirect('/');

		}

		return $next($request);
	}
}
