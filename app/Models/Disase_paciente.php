<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disase_paciente extends Model
{
    use HasFactory;
    protected $fillable =['tipolicencia_id'];

    public function tipolicencias()
    {
        return $this->belongsTo('App\Models\Tipolicencia', 'tipolicencia_id', 'id');
    }
}
