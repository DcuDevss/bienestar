<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Appoinment extends Model
{
    use HasFactory;
    use Notifiable;

    const PENDING   = 'PENDING';
    const CONFIRMED   = 'CONFIRMED';
    const ACCOMPLISHED   = 'ACCOMPLISHED';
    const UNREALIZED   = 'UNREALIZED';
    const CANCELED   = 'CANCELED';

    protected $guarded=[];

    protected $dates = [//esto castea la fecha para el format y los trata como un objeto carbon
        'created_at',
        'updated_at',
        'date',
        'hour'
        // your other new column
    ];

public function getPatientAttribute(){//aqui antes el modelo era user
    $patient = Paciente::find($this->paciente_id);
    return $patient;
}//esto nos deveulve el patient

public function getDoctorAttribute(){
    $doctor = User::find($this->doctor_id);
    return $doctor;//esto nos devuleve le doctor
}

public function getSpecialtyAttribute(){
    $specialty = Especialidade::find($this->especialidade_id);
    return $specialty;
}

public function getOficinaAttribute(){
    $oficina = Oficina::find($this->office);
    return $oficina;

}





public function user(){
    return $this->belongsTo(User::class); //oka Asegúrate de especificar la clave foránea correctamente
}


}
