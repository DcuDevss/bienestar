<div class="w-full text-[12px]">
    <!-- Recuadro para mostrar pacientes con finalización hoy -->
    @if($pacientesConFinalizacionHoy->isNotEmpty())
        <div class="subTab2 bg-gray-800 pr-2 pl-1 mt-4 rounded-lg  max-h-[36rem] overflow-y-auto">
            <div class="flex flex-col items-center justify-center  mx-auto py-2">
                <span class="text-white text-lg font-semibold">Personal que finaliza hoy:</span>
            </div>
            {{-- TABLA --}}
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="teGead2 text-xs text-white uppercase bg-gray-900">
                    <tr class="">
                        <th scope="col" class="pr-2 pl-1 py-3">N°</th>
                        <th scope="col" class="px-2 py-3">Apellido y nombre</th>
                        <th scope="col" class="px-2 py-3">Legajo</th>
                        <th scope="col" class="px-2 py-3">Ciudad</th>
                        <th scope="col" class="px-2 py-3">Destino</th>
                        <th scope="col" class="px-2 py-3">Finalizacion licencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pacientesConFinalizacionHoy as $paciente)
                        <tr wire:key="{{ $paciente->id }}" class="border-b border-gray-700 text-[12px] hover:bg-[#204060]">
                            <td scope="row" class="fak pl-2 py-4 font-medium text-white  dark:text-white">{{ $paciente->id }}</td>
                            <td class="fak pl-2 py-4 font-medium text-white  dark:text-white">{{ $paciente->apellido_nombre }}</td>
                            <td class="fak px-4 py-4 text-gray-300">{{ $paciente->legajo }}</td>
                            <td class="fak px-4 py-4 text-gray-300">{{ $paciente->ciudad }}</td>
                            <td class="fak px-4 py-4 text-gray-300">{{ $paciente->destino_actual }}</td>
                            <td class="fak px-2 py-4
                                @php
                                    $ultimaEnfermedad = $paciente->disases->last();
                                @endphp
                                @if ($ultimaEnfermedad && $ultimaEnfermedad->pivot && $ultimaEnfermedad->pivot->fecha_finalizacion_licencia)
                                    @php
                                        $fechaFinalizacionLicencia = \Carbon\Carbon::parse($ultimaEnfermedad->pivot->fecha_finalizacion_licencia);
                                    @endphp
                                    @if ($fechaFinalizacionLicencia->startOfDay() == \Carbon\Carbon::now()->startOfDay())
                                        bg-yellow-200 bg-opacity-50 animate-pulse
                                    @endif
                                @endif
                                rounded-md font-semibold text-xs text-white uppercase tracking-widest
                            ">
                                @if ($ultimaEnfermedad && $ultimaEnfermedad->pivot && $ultimaEnfermedad->pivot->fecha_finalizacion_licencia)
                                    {{ $fechaFinalizacionLicencia->format('d-m-Y H:i:s') }}
                                @else
                                    Sin fecha
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
