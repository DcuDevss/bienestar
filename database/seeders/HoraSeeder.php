<?php

namespace Database\Seeders;

use App\Models\Hora;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//use Illuminate\Support\Carbon;// con esto la horas del dia las transformamos en un formato carbon.
use Carbon\Carbon;
class HoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    //divido las horas en intervalo de 30minutos osea de las 24horas en las transfromamos en 48hs
    public function run(): void
    {
        $hora = '00:00:00'; //hora de incnio
        $hora = new Carbon($hora);//con carbon transformamos  ese string en un objeto

        //dividimos el dia en media horas y no idica en q turno estamos del dia
        for ($i = 0; $i < 48; $i++) {
            if ($i < 12) {
                $turn = 'dawn';
            } elseif ($i >= 12 && $i <= 24) {
                $turn = "morning";
            } elseif ($i > 24 && $i <= 36) {
                $turn = "afternoon";
            } elseif ($i > 36 && $i <= 47) {
                $turn = "evening";
            }

        $interval = $hora->format('g:i A');//damos el formato hora, minutos,segundos AM/PM

        $newHour = Hora::create([
            'time_hour' => $hora,
            'str_hour_12' => $hora->format('g:i A'),
            'str_hour_24' => $hora->toTimeString(),
            'int_hour' => $i,
            'turn' => $turn,
            'interval' => $interval,
        ]);

        $hora->addMinutes(30);
        $interval = $interval . ' - ' . $hora->format('g:i A');
        $newHour->interval = $interval;
        $newHour->save();
    }}



}
