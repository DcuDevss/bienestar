<?php


namespace App\Support;
use App\Models\Audit;
use Illuminate\Support\Facades\Log;

class AuditLog
{
    /**
     * Loguea una acción.
     *
     * @param  string               $action       ej: 'certificado.create'
     * @param  \Illuminate\Database\Eloquent\Model|null $auditable  modelo afectado (Paciente, Entrevista, etc.)
     * @param  string|null          $description  texto libre
     */
    public static function log(string $action, $auditable = null, ?string $description = null): void
    {
        $user = auth()->user();
        $req  = request();
    Log::info('IPs debug', [
        'X-Forwarded-For' => $req->header('X-Forwarded-For'),
        'X-Real-IP' => $req->header('X-Real-IP'),
        'CF-Connecting-IP' => $req->header('CF-Connecting-IP'),
        'ip_detected' => $req->ip(),
    ]);
        Audit::create([
            'user_id'        => $user?->id,
            'action'         => $action,
            'auditable_type' => $auditable?->getMorphClass(),
            'auditable_id'   => $auditable?->getKey(),
            'description'    => $description,
            'ip_address' => $req->header('CF-Connecting-IP')
                ?: ($req->header('X-Forwarded-For') ? explode(',', $req->header('X-Forwarded-For'))[0] : null)
                ?: $req->header('X-Real-IP')
                ?: $req->ip(),
            'user_agent'     => substr((string) $req?->userAgent(), 0, 255),
        ]);
    }
}
