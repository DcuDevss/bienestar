<?php

use App\Support\AuditLog;

if (!function_exists('audit_log')) {
    /**
     * Helper global para registrar auditorías.
     *
     * @param string $action
     * @param \Illuminate\Database\Eloquent\Model|null $auditable
     * @param string|null $description
     */
    function audit_log(string $action, $auditable = null, ?string $description = null): void
    {
        AuditLog::log($action, $auditable, $description);
    }
}
