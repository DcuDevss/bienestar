<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diadetrabajo extends Model
{
    const MONEDA="$";

    use HasFactory;

    protected $guarded = [];//esto agarra todos los campos y no tener que escribirlos.


    public static function addWorkdays(){//aqui creamos los 7 regiatros necesarios para cad doctor cada doctor debe tener un registro por dia
        for($i=0; $i<7;$i++){
            Diadetrabajo::create([
                'active' =>false,
                'day' =>$i,
                'morning_start'=>13,
                'morning_end'=>13,
                'afternoon_start'=>25,
                'afternoon_end'=>25,
                'evening_start'=>37,
                'evening_end'=>37,
                'morning_office'=>0,
                'afternoon_office'=>0,
                'evening_office'=>0,
                'morning_price'=>0,
                'afternoon_price'=>0,
                'evening_price'=>0,
                'doctor_id'=>auth()->user()->id
            ]);
        }
    }

    public function getHourMSAttribute(){//esto busca el id del modelo hora y depues devolvemos ese id como respuesta a nuestra funcion
        $hour12 = Hora::find($this->morning_start);
        return $hour12->str_hour_12;//nos retona de la tabla horas str_hour_12
    }

    public function getHourMEAttribute(){
        $hour12 = Hora::find($this->morning_end);//aqui envimaos morning_end
        return $hour12->str_hour_12;//retornamos la hora de finalizacion.
    }

    public function getHourASAttribute(){
        $hour12 = Hora::find($this->afternoon_start);
        return $hour12->str_hour_12;//idem para la tarde(inicio)
    }

    public function getHourAEAttribute(){
        $hour12 = Hora::find($this->afternoon_end);
        return $hour12->str_hour_12;//(finalizacion)
    }

    public function getHourESAttribute(){
        $hour12 = Hora::find($this->evening_start);
        return $hour12->str_hour_12;
    }

    public function getHourEEAttribute(){
        $hour12 = Hora::find($this->evening_end);
        return $hour12->str_hour_12;
    }

    public function getMOAttribute(){
        $office = Oficina::find($this->morning_office);
        if($office){
            $address= $office->local.', '.$office->address;
        }else{
            $address="No tiene oficina registrada";
        }
        return $address;
    }

    public function getAOAttribute(){
        $office = Oficina::find($this->afternoon_office);
        if($office){
            $address= $office->local.', '.$office->address;
        }else{
            $address="No tiene oficina registrada";
        }
        return $address;
    }

    public function getEOAttribute(){
        $office = Oficina::find($this->evening_office);
        if($office){
            $address= $office->local.', '.$office->address;
        }else{
            $address="No tiene oficina registrada";
        }
        return $address;
    }


  public function doctor(){
      return $this->belongsTo(Doctor::class);
  }

}
