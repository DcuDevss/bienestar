<?php

namespace Database\Seeders;

use App\Models\Diadetrabajo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiadetrabajoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = User::role(['doctor'])->get();

        foreach($doctors as $doctor){

            $numero = random_int(0,120);
            if($numero % 2 == 0){$active=true;}else{$active=false;}


            $office =  $doctor->offices()->first();
     if($office){

            for($i=0; $i<7;$i++){
                $hora = random_int(0,6);
                Diadetrabajo::create([
                    'active' =>$active,
                    'day' =>$i,
                    'morning_start'=>13,
                    'morning_end'=>13+$hora,
                    'afternoon_start'=>25,
                    'afternoon_end'=>25+$hora,
                    'evening_start'=>37,
                    'evening_end'=>37+$hora,
                    'morning_office'=>$office->id,
                    'afternoon_office'=>$office->id,
                    'evening_office'=>$office->id,
                    'morning_price'=>$numero,
                    'afternoon_price'=>$numero,
                    'evening_price'=>$numero,
                    'doctor_id'=>$doctor->id
                ]);
            }}
        }

    }
}
