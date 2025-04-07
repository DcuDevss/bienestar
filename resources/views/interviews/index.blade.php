<x-app-layout>
    <section class="mt-6">
        <h1 class="text-center text-2xl font-semibold text-slate-800 py-1">{{ __('Datos del paciente') }}</h1>
    </section>
    {{--  <form method="post" action="{{ route('reset-sums', $paciente->id) }}">
        @csrf
        <button type="submit" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-md">
            Reiniciar Sumas
        </button>
    </form> --}}

    <div class="container w-[95%] bg-slate-800 rounded-md py-1 flex mx-auto">
        <!-- CERTIFICADO -->
        <section class="px-1">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-1">
                <div class="col-span-1 md:col-span-3">
                    <div>
                        <div class="bg-white p-3 rounded-md">

                            <div class="image overflow-hidden flex items-center justify-center">
                                <img class="h-[200px] mx-auto" src="{{ asset('assets/defaultPicture.jpg') }}" />
                            </div>
                            <h1 class="text-center font-bold text-gray-900 leading-8 my-1">
                                {{ $paciente->apellido_nombre }}</h1>
                            @can('users.index')
                                <div>
                                    @livewire('interview.interview-reset', ['paciente' => $paciente])
                                </div>
                            @endcan
                            <p class=" text-slate-800 font-semibold capitalize">
                                @if ($sumaSalud)
                                    <div class="flex text-sm">
                                        <p class="font-semibold capitalize">{{ __('Salud ') }} </p>
                                        <p class="font-semibold capitalize"> dias: {{ $sumaSalud }}</p>
                                    </div>
                                    <div
                                        class="{{ $sumaSalud >= 30 ? 'animate-pulse bg-red-500' : ($sumaSalud >= 28 ? 'animate-pulse bg-yellow-500' : '') }} p-2 rounded-md">
                                        <p class="text-white font-semibold">
                                            {{ $sumaSalud >= 30 ? '¡Alerta roja! dias de salud cumplidos' : ($sumaSalud >= 28 ? '¡Precaución! llegando al límite de salud' : '') }}
                                        </p>
                                    </div>
                                @else
                                    <p class="">No posee dias de salud.</p>
                                @endif
                            </p>
                            <p class=" text-slate-800 font-semibold capitalize">
                                @if ($atencionFamiliar)
                                    <div class="flex text-sm">
                                        <p class="px-3  font-semibold capitalize">{{ __('Atencion familiar') }} </p>
                                        <p class="px-3  font-semibold capitalize">dias: {{ $atencionFamiliar }}</p>
                                    </div>
                                    <div
                                        class="{{ $atencionFamiliar >= 20 ? 'animate-pulse bg-red-500' : ($atencionFamiliar >= 18 ? 'animate-pulse bg-yellow-500' : '') }} p-2 rounded-md mb-2 ">
                                        <p class="text-white font-semibold">
                                            {{ $atencionFamiliar >= 20 ? '¡Alerta roja! atendibles cumplidos' : ($atencionFamiliar >= 18 ? '¡Precaución! llegando al límite de atendibles' : '') }}
                                        </p>
                                    </div>
                                @else
                                    <p>No posee dias de atendible.</p>
                                @endif
                            </p>
                            <ul class="bg-gray-300 rounded mt-1 px-3 py-1 text-gray-500">
                                <li class="flex items-center py-1 capitalize">
                                    <span>Estado:</span>
                                    <span class="ml-auto text-white px-2 py-1 text-sm cursor-pointer rounded">

                                        <td class="px-4">
                                            @if ($paciente->estado_id == 1)
                                                <span
                                                    class="text-white bg-green-600 rounded-md px-2 py-1">{{ $paciente->estados->name }}</span>
                                                <!-- Color por defecto -->
                                            @elseif ($paciente->estado_id == 2)
                                                <span
                                                    class="text-white bg-gray-600 rounded-md px-2 py-1">{{ $paciente->estados->name }}</span>
                                                <!-- Color rojo medio -->
                                            @elseif ($paciente->estado_id == 3)
                                                <span
                                                    class="text-black bg-yellow-400 rounded-md px-2 py-1">{{ $paciente->estados->name }}</span>
                                                <!-- Color azul -->
                                            @elseif ($paciente->estado_id == 4)
                                                <span
                                                    class="text-white bg-red-700 rounded-md px-2 py-1">{{ $paciente->estados->name }}</span>
                                                <!-- Color rojo fuerte -->
                                            @elseif ($paciente->estado_id == 5)
                                                <span
                                                    class="text-white bg-black  rounded-md px-2 py-1">{{ $paciente->estados->name }}</span>
                                                <!-- Color amarillo -->
                                            @else
                                                <span class=""></span>
                                                <!-- Color por defecto para otros casos -->
                                            @endif
                                        </td>
                                    </span>
                                </li>
                                {{--   <li class="flex items-center py-3 capitalize">
                                    <div class="flex">
                                        <div class="px-1 py-1 font-semibold capitalize">{{ __('ultima fecha de atencion')}}</div>
                                        @can('doctor')@endcan
                                        <p class=" py-1 text-slate-800 font-semibold capitalize">
                                            @if ($ultimaFechaEnfermedad)
                                            <div class="flex justify-between items-center">
                                                <span class="cursor-pointer px-1 rounded-md py-1 bg-slate-900 text-white">{{ $ultimaFechaEnfermedad->pivot->fecha_finalizacion_licencia }}</span>
                                            </div>
                                        @else
                                            <p>No hay información.</p>
                                        @endif
                                        </p>

                                    </div>

                                </li>
                                <li class="flex items-center py-3 capitalize">
                                    <div class="flex">
                                        <div class="px-1 py-1 font-semibold capitalize">{{ __('ultima fecha de atencion')}}</div>
                                        @can('doctor')@endcan
                                        <p class="py-1 text-slate-800 font-semibold capitalize">
                                            @if ($ultimaFechaEnfermedad)
                                                <div class="flex justify-between items-center">
                                                    <span class="cursor-pointer px-1 rounded-md py-1 bg-slate-900 text-white">
                                                        {{ $ultimaFechaEnfermedad->pivot->fecha_finalizacion_licencia->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                            @else
                                                <p>No hay información.</p>
                                            @endif
                                        </p>
                                    </div>
                                </li> --}}

                                <li class="flex items-center py-3 capitalize">
                                    <div class="flex flex-col">
                                        <div class="py-1 font-semibold capitalize">
                                            <span class="">{{ __('ultimo certificado finalizado:') }}</span>
                                        </div>
                                        <div>
                                            @can('doctor')
                                            @endcan
                                            <p class="px-1 text-slate-800 font-semibold capitalize">
                                                @if ($ultimaFechaEnfermedad)
                                                    <div class="flex justify-between items-center">
                                                        @php
                                                            $fechaFinalizacionLicencia = \Carbon\Carbon::createFromFormat(
                                                                'Y-m-d H:i:s',
                                                                $ultimaFechaEnfermedad->pivot
                                                                    ->fecha_finalizacion_licencia,
                                                            );
                                                        @endphp
                                                        <span
                                                            class="cursor-pointer px-1 rounded-md py-1 bg-slate-900 text-white">
                                                            {{ $fechaFinalizacionLicencia->format('d/m/Y H:i:s') }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <p>No posee información de fechas.</p>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </li>


                            </ul>
                        </div>
                        <!--  -->
                        <div>
                            {{--   @livewire('patient.patient-disase', ['paciente' => $paciente->id]) --}}
                            {{--  @livewire('patient.patient-surgery', ['user' => $user->id]) --}}
                        </div>
                        <!--  -->
                    </div>
                </div>
                <!-- DATOS PERSONALES -->
                <div class="col-span-1 md:col-span-9 bg-white rounded p-8">
                        <div class="grid grid-cols-3 md:grid-cols-3 text-gray-400">
                            <div class="flex">
                                <p class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('nombre:') }}</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->apellido_nombre }}</p>
                            </div>

                            <div class="flex">
                                <div class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('legajo') }} : </div>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->legajo }}</p>
                            </div>

                            <div class="flex">
                                <div class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('jerarquia') }} : </div>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->jerarquias->name}}</p>
                            </div>

                            <div class="flex">
                                <div class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('dni') }} : </div>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->dni }}</p>
                            </div>

                            <div class="flex">
                                <div class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('cuil') }} : </div>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->cuil }}</p>
                            </div>

                            <div class="flex">
                                <div class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('estado') }} : </div>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->estados->name }}</p>
                            </div>

                            <div class="flex">
                                <div class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('destino actual') }} : </div>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize whitespace-normal min-w-[200px]">{{ $paciente->destino_actual }}</p>
                            </div>

                            <div class="flex">
                                <div class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('ciudad') }} : </div>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->ciudad }}</p>
                            </div>

                            <div class="flex">
                                <div class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('legajo') }} : </div>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->legajo }}</p>
                            </div>

                            <div class="flex">
                                <div class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('antigüedad') }} : </div>
                                <p class="px-3 py-1 text-slate-800 font-semibold ">{{ $paciente->edad }} años.</p>

                            </div>
                            <div class="flex">
                                <p class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('sexo') }} :</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->sexo }}</p>
                            </div>
                            <div class="flex">
                                <p class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('contacto') }} :</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->TelefonoCelular }}</p>

                            </div>
                            <div class="flex">
                                <p class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('fecha de nacimiento') }} :</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->fecha_nacimiento }}</p>

                            </div>

                            <div class="flex">
                                <p class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('email') }} :</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->email }}</p>
                            </div>

                            <div class="flex">
                                <p class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('domicilio') }} :</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->domicilio }}</p>
                            </div>
                            <div class="flex">
                                <p class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('peso') }} :</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->peso }}</p>
                            </div>
                            <div class="flex">
                                <p class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('altura') }} :</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->altura }}</p>
                            </div>
                            <div class="flex">
                                <p class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('grupo y fator sanguineo') }} :</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{-- $paciente->factores->name --}}</p>
                            </div>

                            <div class="flex">
                                <p class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('fecha de entrevista medica') }} :</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->direccion }}</p>
                            </div>

                            <div class="flex">
                                <p class="px-4 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('medicamentos que consume') }} :</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->remedios }}</p>
                            </div>

                            <div class="flex">
                                <p class="px-3 py-1 font-semibold underline decoration-thick decoration-blue-500 capitalize">{{ __('enfermedad en curso/congenita') }} :</p>
                                <p class="px-3 py-1 text-slate-800 font-semibold capitalize">{{ $paciente->enfermedad }}</p>
                            </div>

                        </div>




                    <div class="flex flex-1">
                        <a href="{{ route('patient-certificados.show', $paciente->id) }}"
                            class="flex-1 px-3 py-3 bg-gray-300 hover:text-gray-600 text-center text-black my-12 mr-4">
                            {{ __('historial certificados medicos ') }}
                        </a>

                        @can('patient-enfermedades.show')
                            <a href="{{ route('patient-enfermedades.show', $paciente->id) }}"
                                class="flex-1 px-3 py-3 bg-gray-300 mr-2 hover:text-gray-600 text-center text-black my-12">
                                {{ __('historial atencion medica ') }}
                            </a>
                        @endcan
                    </div>
                    <div class='flex flex-1'>
                        <div class="col-span-3 flex-1 md:col-span-2">
                            @livewire('patient.patient-certificado', ['paciente' => $paciente->id])
                        </div>

                        @can('patient-enfermedades.show')
                            <div class="col-span-3 flex-1 md:col-span-2">
                                @livewire('patient.patient-enfermedade', ['paciente' => $paciente->id])
                            </div>
                        @endcan
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 text-gray-400 gap-4">

                        <div class="col-span-3 md:col-span-2">
                            {{-- @livewire('patient.patient-interview', ['paciente' => $paciente->id])  --}}
                        </div>

                        <div class="col-span-3 md:col-span-1">
                            {{-- @livewire('patient.patient-list-interview', ['user' => $user->id]) --}}

                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- MENU VERTICAL -->
        <section class="w-1/4 pr-1">
            <div class="bg-white rounded-md p-2">
                <!-- BOTONES -->
                <div>
                    <ul class="">
                        <!-- CONTROL PACIENTE -->
                        <li class="py-2 text-center">
                            @can('enfermero.enfermero-historial')
                                @livewire('enfermero.control-paciente', ['paciente' => $paciente])
                            @endcan
                        </li>
                        <!-- HISTORIAL DE CONTROL -->
                        <li class="text-center">
                            @can('enfermero.enfermero-historial')
                                <a href="{{ route('enfermero.enfermero-historial', $paciente->id) }}" class="rounded-md">
                                    <div
                                        class="mx-auto px-4 py-3 w-[89%] bg-[#546778] text-white rounded-md transform transition-transform hover:scale-105">
                                        <span>{{ __('Historial de control') }}</span>
                                    </div>
                                </a>
                            @endcan
                        </li>
                    </ul>
                </div>
            </div>
            <!-- BOTONES 2 -->
            <div class="bg-white rounded-md p-2 mt-1">
                <div>
                    <ul>
                        <!-- ADJUNTAR PDF -->
                        <li class="py-2 text-center">
                            <div class="col-span-3 flex-1 md:col-span-2">
                                @livewire('paciente.file-controller', ['paciente' => $paciente])
                            </div>
                        </li>
                        <!-- HISTORIAL PDF -->
                        <li>
                            <a href="{{ route('paciente.ver-historial', $paciente->id) }}" class="rounded-md">
                                <div
                                    class=" mx-auto px-4 py-3 w-[90%] bg-[#546778] text-white text-center rounded-md transform transition-transform hover:scale-105">
                                    <span>{{ __('Historial de PDF') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- BOTONES 3 -->
            <div class="bg-white rounded-md p-2 mt-1">
                <div>
                    <ul>
                        <!-- TRATAMIENTOS -->
                        <li class="py-2 text-center">
                            <a href="{{ route('patient.patient-tratamiento', $paciente->id) }}" class="rounded-md">
                                <div
                                    class="mx-auto px-4 py-3 w-[89%] bg-slate-800 text-white rounded-md transform transition-transform hover:scale-105">
                                    <span>{{ __('Tratamiento') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            @can('users.index')
                <!-- BOTONES 4 -->
                <div class="bg-white rounded-md p-2 mt-1">
                    <div>
                        <ul>
                            <!-- REINICIAR DIAS DE LICENCIA -->
                            <li class="py-2 text-center">
                                <a href="">
                                    <div
                                        class="mx-auto w-[89%]  bg-black text-white rounded-md transform transition-transform hover:scale-105">
                                        @livewire('interview.interview-general')
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endcan
        </section>
    </div>
</x-app-layout>
