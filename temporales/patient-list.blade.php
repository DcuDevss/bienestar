

<div>
    <section class="mt-1">
        <div class="mx-auto  px-4 ">
            <!-- Start coding here -->
            <div class="bg-gray-800  shadow-md sm:rounded-lg ">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex">
                        <div class="w-full">
                            <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                placeholder="Buscar..." required="">
                        </div>
                    </div>

                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-white uppercase bg-gray-900">
                            <tr>
                                <th scope="col" class="px-4 py-3">N°</th>
                                <th scope="col" class="px-4 py-3">Apellido y nombre</th>
                                <th scope="col" class="px-4 py-3">DNI</th>
                                <th scope="col" class="px-4 py-3">legajo</th>
                                <th scope="col" class="px-4 py-3">Jerarquia</th>
                                <th scope="col" class="px-4 py-3">Destino</th>
                                <th scope="col" class="px-4 py-3">Ciudad</th>
                                <th scope="col" class="px-4 py-3">Estado</th>
                                <th scope="col" class="px-4 py-3">Finalizacion licencia</th>
                                <th scope="col" class="px-4 py-3">Accion</th>
                                <th scope="col" class="px-4 py-3">Entrevista</th>
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
                                <th scope="col" class="px-4 py-3">Last update</th> --}}
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pacientes as $paciente)
                                <tr wire:key="{{ $paciente->id }}" class=" dark:border-gray-700">
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-white whitespace-nowrap dark:text-white">
                                        {{ $paciente->id }}</th>
                                    <th class="px-4 py-3 font-medium text-white whitespace-nowrap dark:text-white">
                                        {{ $paciente->apellido_nombre }}</th>
                                    <td class="px-4 py-3 text-gray-300">{{ $paciente->dni }}</td>
                                    <td class="px-4 py-3 text-gray-300">{{ $paciente->legajo }}</td>
                                    <td class="px-4 py-3 text-gray-300">{{ $paciente->jerarquia }}</td>
                                    <td class="px-4 py-3 text-gray-300">{{ $paciente->destino_actual }}</td>
                                    <td class="px-4 py-3 text-gray-300">{{ $paciente->ciudad }}</td>

                                    <!-- ... (resto de tu código) -->

                                    <td class="px-2 py-3">
                                        @if ($paciente->estado_id == 1)
                                            <span class="text-white bg-green-600 rounded-md p-2">{{ $paciente->estados->name }}</span> <!-- Color por defecto -->
                                        @elseif ($paciente->estado_id == 2)
                                            <span class="text-white bg-gray-600 rounded-md p-2">{{ $paciente->estados->name }}</span> <!-- Color rojo medio -->
                                        @elseif ($paciente->estado_id == 3)
                                            <span class="text-black bg-yellow-400 rounded-md p-2">{{ $paciente->estados->name }}</span> <!-- Color azul -->
                                        @elseif ($paciente->estado_id == 4)
                                            <span class="text-white bg-red-700 rounded-md p-2">{{ $paciente->estados->name }}</span> <!-- Color rojo fuerte -->
                                        @elseif ($paciente->estado_id == 5)
                                            <span class="text-white bg-black rounded-md p-2">{{ $paciente->estados->name }}</span> <!-- Color amarillo -->
                                        @else
                                            <span class=""></span>
                                            <!-- Color por defecto para otros casos -->
                                        @endif
                                        <td class="px-4 py-3 text-gray-900
                                        @php
                                            $ultimaEnfermedad = $paciente->disases->last();
                                        @endphp
                                        @if ($ultimaEnfermedad && $ultimaEnfermedad->pivot && $ultimaEnfermedad->pivot->fecha_finalizacion_licencia)
                                            @php
                                                $fechaFinalizacionLicencia = \Carbon\Carbon::parse($ultimaEnfermedad->pivot->fecha_finalizacion_licencia);
                                            @endphp
                                            @if ($fechaFinalizacionLicencia->startOfDay() == \Carbon\Carbon::now()->startOfDay())
                                                bg-yellow-200 bg-opacity-50 animate-pulse /* Amarillo con transparencia y animación de pulso */
                                            @endif
                                        @endif
                                        rounded-md font-semibold text-xs text-white uppercase tracking-widest  focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition"
                                    >
                                        @if ($ultimaEnfermedad && $ultimaEnfermedad->pivot && $ultimaEnfermedad->pivot->fecha_finalizacion_licencia)
                                            {{ $ultimaEnfermedad->pivot->fecha_finalizacion_licencia }}
                                        @else
                                            Sin fecha
                                        @endif
                                    </td>









                                    <td class="px-4 py-3">
                                        <button
                                            onclick="confirm('Seguro desea eliminar a este paciente {{ $paciente->apellido_nombre }} ?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $paciente->id }})"
                                            class="ml-2 px-4 py-[2px] bg-red-500 text-white rounded">X</button>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a class="ml-3 px-4 py-1 rounded-md bg-[#667eea] text-white hover:text-black hover:bg-[#5a67d8]"
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
                                <option value="5">5</option>
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
</div>

