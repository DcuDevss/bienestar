<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Log de TODAS las verificaciones de permisos/can()
        Gate::after(function ($user, string $ability, bool|null $result, array $arguments) {
            Log::channel('perm')->debug('Gate check', [
                'user_id' => $user?->id,
                'email'   => $user?->email,
                'ability' => $ability,   // ej: 'paciente-certificado.edit'
                'result'  => $result,    // true/false/null
                'route'   => request()?->route()?->getName(),
                'uri'     => request()?->path(),
                'mw'      => request()?->route()?->middleware() ?? [],
            ]);
        });
    }
}
