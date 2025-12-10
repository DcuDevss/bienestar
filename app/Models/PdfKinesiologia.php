<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
     * Genera un nombre hasheado para guardar el archivo en el disco
     */
    public static function generateHashedFilename($originalName)
    {
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        return hash('sha256', Str::uuid() . now()) . '.' . strtolower($ext);
    }

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
     * Devuelve el nombre limpio del archivo (para mostrar en la app)
     */
    public function getDisplayNameAttribute()
    {
        return basename($this->filename);
    }
}
