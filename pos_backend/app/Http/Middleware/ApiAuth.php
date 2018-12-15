<?php

namespace App\Http\Middleware;
use Exception;
use Closure;
use App\User;

class ApiAuth
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
        if (!$request->headers->has('Authorization')) {
            return response('Unauthenticated.', 401);
        }
        $user = User::query();
        $user_auth = $user->where('remember_token', $request->header('Authorization'));
        if ($user_auth->count() <= 0) {
            // return abort(401);
            return response('Unauthenticated.', 401);
        }
        return $next($request);
    }
}
