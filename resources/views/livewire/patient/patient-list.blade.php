<div class="padreTablas flex gap-x-2 px-6">

    <section class="seccionTab xl:mx-auto lg:mx-auto w-[95%]">
        <div class="mx-auto text-[12px]">
            <!-- Start coding here -->
            <div class="bg-gray-800  shadow-md sm:rounded-lg ">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex flex-row items-end justify-between w-full">
                        <div class="w-fit">
                            <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-1 pt-1"
                                placeholder="Buscar..." required="">

                        </div>
                        <!-- BOTON AGREGAR -->
                        <div class="">
                            <a href="{{route('multiform.index')}}" class="pr-3 pl-2 py-2 text-white bg-[#2d5986] rounded-md hover:text-white hover:bg-[#3973ac]">
                                <span class="text-[20px]">+ </span>
                                <span class="agre text-[13px]">AGREGAR</span>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-500 ">
                        <thead class=" text-xs text-white uppercase bg-gray-900">
                            <tr class="teGead text-[14px]">
                                <th scope="col" class="px-4 py-3">N°</th>
                                <th scope="col" class="px-4 py-3">Apellido y nombre</th>
                                <th scope="col" class="px-4 py-3">DNI</th>
                                <th scope="col" class="px-4 py-3">legajo</th>
                                <th scope="col" class="px-4 py-3">Jerarquia</th>
                                <th scope="col" class="px-4 py-3">Destino</th>
                                <th scope="col" class="px-4 py-3">Ciudad</th>
{{--                                 <th scope="col" class="px-4 py-3">Estado</th> --}}
                                <th scope="col" class="px-4 py-3">Email</th>
                                <th scope="col" class="px-4 py-3">Celular</th>
                                <th scope="col" class="px-4 py-3">Revista</th>
                                <th scope="col" class="px-4 py-3">Finalizacion licencia</th>
                                <th scope="col" class="px-4 py-3">Accion</th>
                                <th scope="col" class="px-3 py-3">Entrevista</th>
                                    {{-- @include('livewire.includes.table-sortable-th',[
                                            'name' => 'id',
                                            'displayName' => 'Nro'
                                        ])
                                        @include('livewire.includes.table-sortable-th',[
                                            'name' => 'apellido_nombre',
                                            'displayName' => 'Nombre y apellido'
                                        ])
                                        @include('livewire.includes.table-sortable-th',[
                                            'name' => 'dni',
                                            'displayName' => 'DNI'
                                        ])
                                        @include('livewire.includes.table-sortable-th',[
                                            'name' => 'legajo',
                                            'displayName' => 'Legajo'
                                        ])
                                        @include('livewire.includes.table-sortable-th',[
                                            'name' => 'jerarquia',
                                            'displayName' => 'Jerarquia'
                                        ])
                                        <th scope="col" class="px-4 py-3">Last update</th>
                                    --}}
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($pacientes as $paciente)
                                <tr wire:key="{{ $paciente->id }}" class="border-b border-gray-700 hover:bg-[#204060]">
                                    <th class="tiBody px-4 py-1 text-[14px] font-medium text-white whitespace-nowrap dark:text-white">{{ $paciente->id }}</th>
                                    <th class="tiBody px-4 py-1 text-[14px] font-medium text-white whitespace-normal min-w-[200px] dark:text-white">{{ $paciente->apellido_nombre }}</th>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->dni }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->legajo }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->jerarquia_id ? $paciente->jerarquias->name : 'No asignado' }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->destino_actual }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->ciudad }}</td>
{{--                                     <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->estado }}</td> --}}
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->email }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->TelefonoCelular }}</td>

                                    <!-- ... (resto de tu código) -->

                                    <td class="tiBody px-2 py-1 text-[14px]">
                                        @if ($paciente->estado_id == 1)
                                            <span class="bg-green-600 text-white rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span> <!-- Color por defecto -->
                                        @elseif ($paciente->estado_id == 2)
                                            <span class="text-white bg-gray-600 rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span> <!-- Color rojo medio -->
                                        @elseif ($paciente->estado_id == 3)
                                            <span class="text-black bg-yellow-400 rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span> <!-- Color azul -->
                                        @elseif ($paciente->estado_id == 4)
                                            <span class="text-white bg-red-700 rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span> <!-- Color rojo fuerte -->
                                        @elseif ($paciente->estado_id == 5)
                                            <span class="text-white bg-black rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span> <!-- Color amarillo -->
                                        @else
                                            <span class=""></span>
                                            <!-- Color por defecto para otros casos -->
                                        @endif
                                        <td class="tiBody px-4 py-3
                                        @php
                                            $ultimaEnfermedad = $paciente->disases->last();
                                        @endphp
                                        @if ($ultimaEnfermedad && $ultimaEnfermedad->pivot && $ultimaEnfermedad->pivot->fecha_finalizacion_licencia)
                                            @php
                                                $fechaFinalizacionLicencia = \Carbon\Carbon::parse($ultimaEnfermedad->pivot->fecha_finalizacion_licencia);
                                            @endphp
                                            @if ($fechaFinalizacionLicencia->startOfDay() == \Carbon\Carbon::now()->startOfDay())
                                                bg-yellow-200 bg-opacity-50 rounded-md animate-pulse /* Amarillo con transparencia y animación de pulso */
                                            @endif
                                        @endif
                                        font-semibold text-xs text-white uppercase tracking-widest  focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition"
                                    >
                                        @if ($ultimaEnfermedad && $ultimaEnfermedad->pivot && $ultimaEnfermedad->pivot->fecha_finalizacion_licencia)
                                            {{ $ultimaEnfermedad->pivot->fecha_finalizacion_licencia }}
                                        @else
                                            Sin fecha
                                        @endif
                                    </td>

                                    <td class="tiBody px-4 py-1 text-[14px]">
                                        <button
                                            onclick="confirm('Seguro desea eliminar a este paciente {{ $paciente->apellido_nombre }} ?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $paciente->id }})"
                                            class="ml-2 px-4 py-[1.5px] bg-red-700 hover:bg-red-600 text-white rounded">X</button>
                                    </td>
                                    <td class="tiBody px-4 py-1 text-[14px]">
                                        <a class="ml-3 px-4 py-1 rounded-md bg-[#2d5986] text-white  hover:bg-[#3973ac]"
                                            href="{{ route('interviews.index', ['paciente' => $paciente->id]) }}">
                                            {{ __('Ir') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="py-4 px-5">
                    <div class="flex">
                        <div class="flex space-x-4 items-center mb-3">
                            <label class="text-sm font-medium text-white">Mostrar</label>
                            <select wire:model.live='perPage'
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                                <option value="6">6</option>
                                <option value="8">8</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    {{ $pacientes->links() }}
                </div>
            </div>
        </div>
    </section>

    <section class="seccionTab2 w-fit">@livewire('patient.patient-listfechas')</section>


</div>


</div>

