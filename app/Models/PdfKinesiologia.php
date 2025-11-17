<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PdfKinesiologia extends Model
{
    use HasFactory;

    protected $table = 'pdf_kinesiologias';

    protected $fillable = [
        'paciente_id',
        'filename',
        'filepath',
    ];

    /**
     * Relación con Paciente
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    /**
     * Devuelve la URL pública para acceder al archivo
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->filepath);
    }

    /**
     * Devuelve el nombre limpio del archivo (por si algún día lo procesás)
     */
    public function getDisplayNameAttribute()
    {
        return basename($this->filename);
    }
}
