<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfPsiquiatra extends Model
{
    use HasFactory;

    protected $fillable = ['paciente_id', 'filename', 'filepath'];

   public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

}
