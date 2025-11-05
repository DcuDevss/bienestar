<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // 403 — sin permisos (@can, Gate, policies, abort(403), etc.)
        if ($e instanceof AuthorizationException) {
            Session::flash('forbidden_message', '⚠️ No tenés permisos para acceder a esta sección.');
            return redirect()->route('dashboard');
        }

        // 5xx — errores de servidor (opcional: solo en producción para no "ocultar" errores en dev)
        if (app()->environment('production') && $e instanceof HttpExceptionInterface) {
            if (in_array($e->getStatusCode(), [500, 502, 503])) {
                Session::flash('forbidden_message', '❌ Hubo un problema interno. Intentá más tarde.');
                return redirect()->route('dashboard');
            }
        }

        return parent::render($request, $e);
    }
}
