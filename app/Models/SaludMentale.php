<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaludMentale extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'codigo',
        'tipo_entrevista_id'
    ];

    public function entrevistas()
    {
        return $this->hasMany(Entrevista::class);
    }

}

