<?php


namespace App\Support;
use App\Models\Audit;

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

        Audit::create([
            'user_id'        => $user?->id,
            'action'         => $action,
            'auditable_type' => $auditable?->getMorphClass(),
            'auditable_id'   => $auditable?->getKey(),
            'description'    => $description,
            'ip_address'     => $req?->ip(),
            'user_agent'     => substr((string) $req?->userAgent(), 0, 255),
        ]);
    }
}
