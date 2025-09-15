<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdfhistorial extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
