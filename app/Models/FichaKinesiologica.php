<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichaKinesiologica extends Model
{
    protected $table = 'fichas_kinesiologicas';

    protected $fillable = [
        // Relaciones
        'paciente_id',
        'doctor_id',
        'obra_social_id',
        'user_id',

        // === I. DATOS ADMINISTRATIVOS / ANAMNESIS ===
        'diagnostico',
        'motivo_consulta',
        'posturas_dolorosas',
        'realiza_actividad_fisica',
        'tipo_actividad',
        'antecedentes_enfermedades',
        'antecedentes_familiares',
        'cirugias',
        'traumatismos_accidentes',
        'tratamientos_previos',
        'menarca',
        'menopausia',
        'partos',
        'estado_salud_general',
        'alteracion_peso',
        'medicacion_actual',
        'observaciones_generales_anamnesis',

        // === II. EXAMEN EOM ===
        // VISCERAL
        'visceral_palpacion',
        'visceral_dermalgias',
        'visceral_triggers',
        'visceral_fijaciones',

        // CRANEAL
        'craneal_forma',
        'craneal_triggers',
        'craneal_fijaciones',
        'craneal_musculos',

        // CARDIOVASCULAR
        'tension_arterial',
        'pulsos',
        'auscultacion',
        'ecg',
        'ecodoppler',
    ];

    protected $casts = [
        'realiza_actividad_fisica' => 'integer',
        'menarca' => 'integer',
        'menopausia' => 'integer',
        'alteracion_peso' => 'integer',
    ];




    // === Relaciones ===

    // Una ficha pertenece a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Una ficha pertenece a un doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Una ficha pertenece a una obra social
    public function obraSocial()
    {
        return $this->belongsTo(ObraSocial::class);
    }

    // 🚀 NUEVA RELACIÓN: Una ficha pertenece a un Usuario (Kinesiólogo creador)
    public function user()
    {
        // Asume que la clave foránea es 'user_id'
        return $this->belongsTo(User::class);
    }
}
