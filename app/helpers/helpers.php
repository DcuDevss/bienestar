<?php

use App\Support\AuditLog;

define('DIA',array('domingo','lunes','martes','miércoles','jueves','viernes','sábado'));

function price($value){
   return number_format($value,2).' $';
}
//esto se crea nuevo para definir los diass

if (!function_exists('audit_log')) {
    /**
     * Helper global para registrar acciones en la auditoría.
     *
     * @param  string  $action       Acción (ej: 'paciente.create', 'certificado.delete')
     * @param  mixed|null  $auditable  Modelo afectado (opcional)
     * @param  string|null  $description  Descripción libre
     * @return void
     */
    function audit_log(string $action, $auditable = null, ?string $description = null): void
    {
        AuditLog::log($action, $auditable, $description);
    }
}
