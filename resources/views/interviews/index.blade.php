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

    <div class="container w-[95%] bg-slate-800 rounded-md py-1 flex mx-auto mb-12">
        <!-- CERTIFICADO -->
        <section class="flex-1 min-w-0 px-1 md:basis-[calc(100%-27rem)]">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-1">
                <div class="col-span-1 md:col-span-3">
                    <div>
                        <div class="bg-white p-3 rounded-md">
                            <div class="image overflow-hidden flex items-center justify-center">
                            <img class="h-[200px] mx-auto" src="{{ asset('assets/defaultPicture.jpg') }}" />
                            </div>

                            <h1 class="text-center font-bold text-gray-900 leading-8 my-1">
                            {{ $paciente->apellido_nombre }}
                            </h1>

                            @can('users.index')
                            <div>
                                @livewire('interview.interview-reset', ['paciente' => $paciente])
                            </div>
                            @endcan

                            {{-- LICENCIAS (corrige <p>, filtra días = 0 y balancea if/else) y mas cambios--}}
                            @php
                            $sumasFiltradas = collect($sumasPorTipo ?? [])
                                ->map(fn($v) => (int)$v)
                                ->filter(fn($v) => $v > 0);
                            @endphp

                            @if($sumasFiltradas->isNotEmpty())
                            <div class="text-slate-800 font-semibold capitalize">
                                <h2 class="text-lg text-center mb-2">Licencias Médicas por Tipo</h2>

                                @foreach($sumasFiltradas as $tipo => $suma)
                                <div class="flex text-sm justify-between items-center mb-1">
                                    <p class="font-semibold capitalize">{{ $tipo }}</p>
                                    <p class="font-semibold capitalize">Días: {{ $suma }}</p>
                                </div>

                                @php $tipoNorm = \Illuminate\Support\Str::lower($tipo); @endphp
                            <p class=" text-slate-800 font-semibold capitalize">
                                @if (!empty($sumasPorTipo) && array_sum($sumasPorTipo) > 0)

                                    <div class="text-slate-800 font-semibold capitalize">
                                        <h2 class="text-lg text-center mb-2">Licencias Médicas por Tipo</h2>

                                        @foreach ($sumasPorTipo as $tipo => $suma)
                                            <div class="flex text-sm justify-between items-center mb-1">
                                                <p class="font-semibold capitalize">{{ $tipo }}</p>
                                                <p class="font-semibold capitalize">Días: {{ $suma }}</p>
                                            </div>

                                            @if ($tipo === 'Enfermedad comun')
                                                @if ($suma >= 30)
                                                    <div
                                                        class="animate-pulse bg-red-500 text-white p-2 rounded-md mb-2">
                                                        ¡Alerta roja! días de salud cumplidos
                                                    </div>
                                                @elseif ($suma >= 28)
                                                    <div
                                                        class="animate-pulse bg-yellow-500 text-black p-2 rounded-md mb-2">
                                                        ¡Precaución! llegando al límite de salud
                                                    </div>
                                                @endif
                                            @elseif ($tipo === 'Atencion familiar')
                                                @if ($suma >= 20)
                                                    <div
                                                        class="animate-pulse bg-red-500 text-white p-2 rounded-md mb-2">
                                                        ¡Alerta roja! atendibles cumplidos
                                                    </div>
                                                @elseif ($suma >= 18)
                                                    <div
                                                        class="animate-pulse bg-yellow-500 text-black p-2 rounded-md mb-2">
                                                        ¡Precaución! llegando al límite de atendibles
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p>No posee días registrados.</p>
                                @endif

                                @if ($tipoNorm === 'enfermedad comun')
                                    @if ($suma >= 30)
                                    <div class="animate-pulse bg-red-500 text-white p-2 rounded-md mb-2">
                                        ¡Alerta roja! días de salud cumplidos
                                    </div>
                                    @elseif ($suma >= 28)
                                    <div class="animate-pulse bg-yellow-500 text-black p-2 rounded-md mb-2">
                                        ¡Precaución! llegando al límite de salud
                                    </div>
                                    @endif
                                @elseif ($tipoNorm === 'atencion familiar')
                                    @if ($suma >= 20)
                                    <div class="animate-pulse bg-red-500 text-white p-2 rounded-md mb-2">
                                        ¡Alerta roja! atendibles cumplidos
                                    </div>
                                    @elseif ($suma >= 18)
                                    <div class="animate-pulse bg-yellow-500 text-black p-2 rounded-md mb-2">
                                        ¡Precaución! llegando al límite de atendibles
                                    </div>
                                    @endif
                                @endif
                                @endforeach
                            </div>
                            @else
                            <p class="text-slate-600">No posee días registrados.</p>
                            @endif

                            <ul class="bg-gray-300 rounded mt-1 px-3 py-1 text-gray-500">
                            <li class="flex items-center py-1 capitalize">
                                <span>Estado:</span>
                                <span class="ml-auto text-white px-2 py-1 text-sm rounded">
                                @if ($paciente->estado_id == 1)
                                    <span class="text-white bg-green-600 rounded-md px-2 py-1">{{ $paciente->estados->name }}</span>
                                @elseif ($paciente->estado_id == 2)
                                    <span class="text-white bg-gray-600 rounded-md px-2 py-1">{{ $paciente->estados->name }}</span>
                                @elseif ($paciente->estado_id == 3)
                                    <span class="text-black bg-yellow-400 rounded-md px-2 py-1">{{ $paciente->estados->name }}</span>
                                @elseif ($paciente->estado_id == 4)
                                    <span class="text-white bg-red-700 rounded-md px-2 py-1">{{ $paciente->estados->name }}</span>
                                @elseif ($paciente->estado_id == 5)
                                    <span class="text-white bg-black rounded-md px-2 py-1">{{ $paciente->estados->name }}</span>
                                @else
                                    <span class="px-2 py-1 rounded-md bg-slate-200 text-slate-700">Sin estado</span>
                                @endif
                                </span>
                            </li>

                            <li class="flex items-center py-3 capitalize w-full">
                                <div class="flex flex-col w-full">
                                <div class="py-1 font-semibold capitalize">
                                    <span>Último certificado finalizado:</span>
                                </div>

                                <div>
                                    @if ($ultimaFechaEnfermedad)
                                    @php
                                        $fechaFinalizacionLicencia = \Carbon\Carbon::createFromFormat(
                                        'Y-m-d H:i:s',
                                        $ultimaFechaEnfermedad->pivot->fecha_finalizacion_licencia
                                        );
                                    @endphp
                                    <div class="flex justify-between items-center">
                                        <span class="cursor-pointer px-1 rounded-md py-1 bg-slate-900 text-white">
                                        {{ $fechaFinalizacionLicencia->format('d/m/Y H:i:s') }}
                                        </span>
                                    </div>
                                    @else
                                    <p>No posee información de fechas.</p>
                                    @endif
                                </div>
                                </div>
                            </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- DATOS PERSONALES -->
                <div class="col-span-1 md:col-span-9 bg-white rounded-xl p-6 md:p-8 shadow-sm">
                        <div class="mb-4">
                            <h2 class="text-xl text-center font-semibold text-slate-800">Datos del Paciente</h2>
                        </div>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-2 text-sm">

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Jerarquía</dt>
                        <dd class="font-semibold text-slate-800 capitalize">{{ $paciente->jerarquias->name }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Nombre</dt>
                        <dd class="font-semibold text-slate-800 capitalize">{{ $paciente->apellido_nombre }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Destino Actual</dt>
                        <dd class="font-semibold text-slate-800 capitalize">{{ $paciente->destino_actual }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">DNI</dt>
                        <dd class="font-semibold text-slate-800">{{ $paciente->dni }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Legajo</dt>
                        <dd class="font-semibold text-slate-800">{{ $paciente->legajo }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">CUIL</dt>
                        <dd class="font-semibold text-slate-800">{{ $paciente->cuil }}</dd>
                        </div>


                        <div class="sm:col-span-2 border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Ciudad</dt>
                        <dd class="font-semibold text-slate-800 capitalize break-words">{{ $paciente->ciudad }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Estado</dt>
                        <dd class="font-semibold text-slate-800 capitalize">{{ $paciente->estados->name }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Edad</dt>
                        <dd class="font-semibold text-slate-800">{{ $paciente->edad }} años</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Sexo</dt>
                        <dd class="font-semibold text-slate-800 capitalize">{{ $paciente->sexo }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Contacto</dt>
                        <dd class="font-semibold text-slate-800">{{ $paciente->TelefonoCelular }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Fecha de nacimiento</dt>
                        <dd class="font-semibold text-slate-800">{{ $paciente->fecha_nacimiento }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Email</dt>
                        <dd class="font-semibold text-slate-800 break-words">{{ $paciente->email }}</dd>
                        </div>

                        <div class="sm:col-span-2 border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Domicilio</dt>
                        <dd class="font-semibold text-slate-800 capitalize">{{ $paciente->domicilio }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Peso</dt>
                        <dd class="font-semibold text-slate-800">{{ $paciente->peso }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Altura</dt>
                        <dd class="font-semibold text-slate-800">{{ $paciente->altura }}</dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Grupo y factor sanguíneo</dt>
                        <dd class="font-semibold text-slate-800">
                            {{ $paciente->factores ? $paciente->factores->name : 'Sin datos' }}
                        </dd>
                        </div>

                        <div class="border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Fecha de entrevista médica</dt>
                        <dd class="font-semibold text-slate-800">{{ $paciente->direccion }}</dd>
                        </div>

                        <div class="sm:col-span-2 border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Medicamentos que consume</dt>
                        <dd class="font-semibold text-slate-800">{{ $paciente->remedios }}</dd>
                        </div>

                        <div class="sm:col-span-2 border-b border-slate-100 pb-1">
                        <dt class="text-slate-500 font-medium">Enfermedad en curso / congénita</dt>
                        <dd class="font-semibold text-slate-800">{{ $paciente->enfermedad }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-3">
                        @can('psicologo.index')
                        <a href="{{ route('entrevista.create', $paciente->id) }}"
                            class="inline-flex items-center justify-center rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-800 hover:bg-slate-100 hover:text-slate-700 transition">
                            Entrevista
                        </a>
                        @endcan

                        <a href="{{ route('patient-certificados.show', $paciente->id) }}"
                        class="inline-flex items-center justify-center rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-800 hover:bg-slate-100 hover:text-slate-700 transition">
                        Historial certificados médicos
                        </a>

                        @can('patient-enfermedades.show')
                        <a href="{{ route('patient-enfermedades.show', $paciente->id) }}"
                            class="inline-flex items-center justify-center rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-800 hover:bg-slate-100 hover:text-slate-700 transition">
                            Historial atención médica
                        </a>
                        @endcan
                    </div>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="rounded-md border border-slate-200 p-3">
                        @livewire('patient.patient-certificado', ['paciente' => $paciente->id])
                        </div>

                        @can('patient-enfermedades.show')
                        <div class="rounded-md border border-slate-200 p-3">
                            @livewire('patient.patient-enfermedade', ['paciente' => $paciente->id])
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </section>
        <!-- MENU VERTICAL -->
        <section class="flex-1 px-1">
            <div class="bg-white p-2 rounded-md">
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

                        </li>
                    </ul>
                </div>
                 @endcan
            </div>
            <!-- BOTONES 2 -->
            <div class="bg-white rounded-md p-2 mt-1 mx-0">
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
            @can('users.index')
            <div class="bg-white rounded-md p-2 mt-1 mx-0">
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
                <!-- BOTONES 4 -->
                <div class="bg-white rounded-md p-2 mt-1 mx-0">
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
    </div>
</x-app-layout>
{{-- comentario de prueba --}}
