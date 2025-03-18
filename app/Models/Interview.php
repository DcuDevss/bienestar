<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $dates = [
        'created_at',
        'updated_at',
        'date',
        // your other new column
    ];


    public function paciente(){
        return $this->belongsTo(Paciente::class,'paciente_id');
    }

    public function getDoctorAttribute(){
        $doctor = User::find($this->doctor_id);
        return $doctor->name;
    }

    public function getPatientAttribute(){
        $doctor = Paciente::find($this->paciente_id);
        return $doctor->name;
    }

    public function files(){
        return $this->belongsToMany(File::class)->withPivot('user_id')->withTimestamps();
    }

}
