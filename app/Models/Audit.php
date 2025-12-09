<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Audit extends Model
{
    protected $fillable = [
        'user_id','action','auditable_type','auditable_id',
        'description','ip_address','user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Para que puedas usar $audit->action_label y $audit->entity_label en la vista
    protected $appends = ['action_label', 'entity_label'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /** ----- LABEL AMIGABLE PARA LA ACCIÓN ----- */
    public function getActionLabelAttribute(): string
    {
        // Mapeá tus claves a textos
        $map = [
            'paciente.create'          => 'Alta de paciente',
            'paciente.update'          => 'Edición de paciente',
            'paciente.delete'          => 'Eliminación de paciente',
            'entrevista.create'        => 'Alta de entrevista',
            'entrevista.update'        => 'Edición de entrevista',
            'certificado.create'       => 'Alta de certificado',
            'certificado.update'       => 'Edición de certificado',
            'catalogo.enfermedad.create'  => 'Nueva enfermedad agregada',
            'paciente.enfermedad.create'  => 'Atención médica agregada',
            'paciente.enfermedad.update'  => 'Atención médica actualizada',
            'control_enfermero.create' => 'Control de enfermería',
            'control_enfermero.update' => 'Edición control de enfermería',
            'disase.create'            => 'Nueva enfermedad',
            'pdf.create'               => 'PDF desde psicologo',
            'archivo.create'           => 'PDF desde archivo',
            'ficha.kinesiologia.actualizacion' => 'Editar Ficha kinesiologica',
            'Doctor.Creacion'      => "Se registro un nuevo Doctor",
            'ficha.kinesiologia.creacion' => 'Ceracion de Ficha Kinesiologica',
            'pdf.Kinesiologia' => 'PDF Kinesiologia',
            'eliminar.pdf' => 'Eliminar PDF Kinesiologia',
            'sesion.edit' => 'Edicion Sesion',
            'sesion.finalizada' => 'Finalizar Sesion',
            'paciente.photo.uploaded' => 'Actualizacion Foto del Paciente',
            'paciente.photo.removed'    => 'Eliminación Foto del Paciente',
            'user.password.update'  => 'Actualización de contraseña'
        ];

        if (isset($map[$this->action])) {
            return $map[$this->action];
        }

        // fallback: “entrevista.create” → “Entrevista • Create”
        return Str::of($this->action)
            ->replace('.', ' • ')
            ->headline()
            ->value();
    }

    /** ----- LABEL AMIGABLE PARA LA ENTIDAD (PACIENTE) ----- */
    public function getEntityLabelAttribute(): ?string
    {
        $model = $this->auditable;

        if (!$model) return null;

        // Si es un Paciente, devolvé su nombre
        if ($model instanceof \App\Models\Paciente) {
            return $model->apellido_nombre ?: ('Paciente #' . $model->getKey());
        }

        // Si es una Enfermedad (Disase o Enfermedade), devolvé el nombre
        if ($model instanceof \App\Models\Disase || $model instanceof \App\Models\Enfermedade) {
            return $model->name ?: ('Enfermedad #' . $model->getKey());
        }

        // Si el modelo relacionado tiene relación paciente(), usala
        if (method_exists($model, 'paciente')) {
            $pac = $model->paciente; // lazy ok para pocos registros
            if ($pac) {
                return $pac->apellido_nombre ?: ('Paciente #' . $pac->getKey());
            }
        }

        // fallback genérico
        return class_basename($model) . ' #' . $model->getKey();
    }

}
