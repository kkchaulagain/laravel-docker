<?php

namespace App\Http\Middleware;

use App\Services\Authorization\AuthorizationService;
use App\Services\Authorization\UserService;
use Closure;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (empty($role) || $role == '*') {
            $role = 'admin,business';
        }
        //get all request headers
        if ($request->hasHeader('authorization') || $request->hasHeader('Authorization')) {
            $token = $request->header('authorization');

            if (!$token) {
                $token = $request->header('Authorization');
            }
            $role = implode(",", explode("-", $role));
            $auth = new AuthorizationService();
            $user = $auth->getUserFromToken($token, $role);
            if ($user) {
                try {
                    $request->authUser  = new UserService((array) $user);
                    return $next($request);
                } catch (\Exception $e) {
                    $message = "Unauthorized";
                    // if ($msg = $e->getMessage()) {
                    //     $message = $msg;
                    // }
                    return  response()->json($message, 401);
                }
            }
        }
        return  response()->json('UnAuthorized', 401);
    }
}
