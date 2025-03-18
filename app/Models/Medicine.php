<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];

    public function pacientes(){
        return $this->belongsToMany(Paciente::class)->withPivot('interview_id','instruction','dosage')->withTimestamps();
    }
}
