<?php

namespace App\Livewire\Patient;

use App\Models\Appoinment;
use App\Models\Diadetrabajo;
use App\Models\Hora;
use Livewire\Component;
use Carbon\Carbon;

class PatientDate extends Component
{
    public $openModal = false;
    public $date, $day, $oficina_id;
    public $appoinments, $doctor_id, $especialidade_id, $intervals = [];
    public $workday, $interval;
    public $morning = [], $afternoon = [], $evening = [];

    protected $listeners = ['selectDate' => 'selectDate', 'addAppoinment' => 'addAppoinment'];

    public function selectDate($doctorID, $specialtyID)
    {
        $this->reset('date');
        $this->morning = [];
        $this->afternoon = [];
        $this->evening = [];
        $this->doctor_id = $doctorID;
        $this->especialidade_id = $specialtyID;
        $this->openModal = true;
    }

    public function updatedDate($value)
    {

        $this->morning = [];
        $this->afternoon = [];
        $this->evening = [];

        $newDate = new Carbon($value);
        $this->day = $newDate->dayOfWeek;
        $work = Diadetrabajo::where('doctor_id', $this->doctor_id)
            ->where('day', $this->day)->first();

        $int1 = $this->getIntervalo($work->morning_start, $work->morning_end);
        $int2 = $this->getIntervalo($work->afternoon_start, $work->afternoon_end);
        $int3 = $this->getIntervalo($work->evening_start, $work->evening_end);

        $this->morning = $int1;
        $this->afternoon = $int2;
        $this->evening = $int3;
    }

    public function getIntervalo($start, $end)
    {
        $appoinments = Appoinment::where('date', $this->date)
            ->where('doctor_id', $this->doctor_id)
            ->pluck('hora_id')->toArray();//caon esto teneemos un array de id que son las horas q asu ves represtean los intervalos q tenemos reservados como citas son slos id de citas

        $array = [];
        if ($start < $end) {
            for ($i = $start; $i <= $end; $i++) {
                $var = Hora::find($i);
                if (!in_array($var->id, $appoinments)) {//aqui comparamos la hora con el appoinment, sino esta se lo agrega al array
                    array_push($array, $var->interval);
                }

            }
        } else {
            $array = [];
        }
        return $array;
    }

    public function selecccionar($m)
    {
        $hour = Hora::where('interval', $m)->first();

        if ($hour) {
            // La hora se encontró, ahora obtenemos el Diadetrabajo
            $work = Diadetrabajo::where('doctor_id', $this->doctor_id)
                ->where('day', $this->day)
                ->first();

            if ($work) {
                // Se encontró el Diadetrabajo, ahora puedes continuar con tu lógica
                switch ($hour->turn) {
                    case 'dawn':
                        $office = $work->evening_office;
                        $price = $work->evening_price;
                        break;
                    case 'morning':
                        $office = $work->morning_office;
                        $price = $work->morning_price;
                        break;
                    case 'afternoon':
                        $office = $work->afternoon_office;
                        $price = $work->afternoon_price;
                        break;
                    case 'evening':
                        $office = $work->evening_office;
                        $price = $work->evening_price;
                        break;
                }

                $this->dispatch('store-data', [
                    'interval' => $hour->interval,
                    'doctor_id' => $this->doctor_id,
                    'especialidade_id' => $this->especialidade_id,
                    'day' => $this->day,
                    'date' => $this->date,
                    'price' => $price,
                    'office' => $office,
                ]);

                if (auth()->user()) {
                    $this->dispatch('delete-data');
                    // Crea cita
                    Appoinment::create([
                        'patient_id' => auth()->user()->id,
                        'doctor_id' => $this->doctor_id,
                        'especialidade_id' => $this->especialidade_id,
                        'date' => $this->date,
                        'hour' => $hour->time_hour,
                        'hora_id' => $hour->id,
                        'office' => $office,
                        // 'price' => $price,
                    ]);
                    $this->dispatch('actualizar');
                    $this->openModal = false;
                } else {
                    // Guardar la cita 'patient.patient-info'
                    $this->openModal = false;
                    // Logear al usuario
                    return redirect()->route('login');
                    // Crear cita
                }
            } else {
                // Manejar el caso en el que no se encuentra el Diadetrabajo
            }
        } else {
            // Manejar el caso en el que no se encuentra la hora
        }
    }


    public function addAppoinment($interval, $doctor_id, $especialidade_id, $day, $date, $price, $office)
    {

        $hour = Hora::where('interval', $interval)->first();
        $work = Diadetrabajo::find($hour->id);

        if(auth()->user())
        {
           Appoinment::create([
            'patient_id' => auth()->user()->id,
            'doctor_id' => $doctor_id,
            'especialidade_id' => $especialidade_id,
            'date' => $date,
            'hour' => $hour->time_hour,
            'hora_id' => $hour->id,
            'office' => $office,
            'price' => $price,
        ]);

       // $this->dispatch('patient.patient-info','actualizar');

        }
        $this->dispatch('delete-data');

    }

    public function render()
    {
        return view('livewire.patient.patient-date');
    }
}
