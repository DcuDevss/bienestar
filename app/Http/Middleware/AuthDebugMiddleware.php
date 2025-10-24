<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthDebugMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        Log::info('Auth debug (middleware)', [
            'path'              => $request->path(),
            'guard_default'     => config('auth.defaults.guard'),
            'permission_guard'  => config('permission.defaults.guard') ?? null,
            'user_id'           => optional($user)->id,
            'guards'            => [
                'web' => auth('web')->check(),
                'api' => auth('api')->check(),
            ],
            'user_roles'        => $user?->getRoleNames(),
            'user_perms'        => $user?->getAllPermissions()->pluck('name'),
            'model_guard'       => method_exists($user ?? null, 'guard_name') ? $user->guard_name : null,
            'cache_driver'      => config('cache.default'),
            'cache_prefix'      => config('cache.prefix'),
            'session_driver'    => config('session.driver'),
            'session_connection'=> config('session.connection'),
        ]);

        return $next($request);
    }
}
