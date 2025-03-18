<div>
    <!-- component -->
    <div>
        <!-- component -->
        <section class="max-w-7xl p-6 mx-auto bg-slate-800 rounded-md shadow-md dark:bg-gray-800 mt-20">
            <h1 class="text-xl font-bold text-white capitalize dark:text-white">Antecedentes pasados</h1>
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">

                    <div>
                        <label class="text-white dark:text-gray-200" for="profesional_enterior">Profesional donde realizo
                            la consulta</label>
                        <input wire:model="profesional_enterior" id="profesional_enterior" type="text"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>

                    <div>
                        <label class="text-white dark:text-gray-200" for="fecha_atencion">Fecha de atencion</label>
                        <input wire:model="fecha_atencion" id="fecha_atencion" type="datetime-local"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>

                    <div>
                        <label class="text-white dark:text-gray-200" for="consumo_farmacos">Consumo de Fármacos</label>
                        <input wire:model="consumo_farmacos" id="consumo_farmacos" type="text"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                    <div>
                        <label for="antecedente_familiar"
                            class="block text-sm font-medium text-white">{{ __('antecedentes familiares') }}</label>
                        <textarea id="antecedente_familiar" class="w-full rounded cursor-pointer" rows="5"
                            placeholder="{{ __('ingrese antcedentes') }}" wire:model="antecedente_familiar"></textarea>{{-- --}}
                    </div>

                    <div>
                        <label for="motivo_consulta_anterior"
                            class="block text-sm font-medium text-white">{{ __('motivo de consulta') }}</label>
                        <textarea id="motivo_consulta_anterior" class="w-full rounded cursor-pointer" rows="5"
                            placeholder="{{ __('ingrese motivo') }}" wire:model="motivo_consulta_anterior"></textarea>{{-- --}}
                    </div>




                </div>
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                    <div>
                        <label class="text-white dark:text-gray-200" for="indicacionterapeutica_id">Indicación
                            Terapéutica ID</label>
                        <select wire:model.lazy="indicacionterapeutica_id"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            <option disabled selected value="">Indicación Terapéutica </option>
                            @foreach ($indicacionterapeuticas as $indicacion)
                                <option value="{{ $indicacion->id }}" class="text-[#666666]">{{ $indicacion->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-white dark:text-gray-200" for="derivacionpsiquiatrica_id">Derivación
                            Psiquiátrica ID</label>

                        <select wire:model.lazy="derivacionpsiquiatrica_id"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            <option disabled selected value="">Derivación Psiquiátrica</option>
                            @foreach ($derivacionpsiquiatricas as $derivacion)
                                <option value="{{ $derivacion->id }}" class="text-[#666666]">{{ $derivacion->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                    <div>
                        <label class="text-white dark:text-gray-200" for="procedencia_id">Procedencia ID</label>
                        <select wire:model.lazy="procedencia_id"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            <option value="" disabled {{ $procedencia_id ? '' : 'selected' }}>Selecciona una
                                procedencia</option>
                            @foreach ($procedencias as $proce)
                                <option value="{{ $proce->id }}" class="text-[#666666]"
                                    {{ $procedencia_id == $proce->id ? 'selected' : '' }}>
                                    {{ $proce->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <div>
                        <label class="text-white dark:text-gray-200" for="enfermedade_id">Enfermedad ID</label>
                        <select wire:model.lazy="enfermedade_id"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            <option disabled selected value="">Enfermedad ID</option>
                            @foreach ($enfermedades as $enfer)
                                <option value="{{ $enfer->id }}" class="text-[#666666]">{{ $enfer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                </div>

                {{-- --}} <div>
                        <label class="text-white dark:text-gray-200" for="tipolicencia_id">Tipo Licencia ID</label>

                        <select wire:model.lazy="tipolicencia_id" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            <option disabled selected value="">Tipo licencia</option>
                            @foreach ($tipolicencias as $tipolic)
                                <option value="{{ $tipolic->id }}" class="text-[#666666]">{{ $tipolic->name }}</option>
                            @endforeach
                        </select>
                    </div>

                {{--  <div>
                        <label class="text-white dark:text-gray-200" for="paciente_id">Paciente ID</label>
                        <input wire:model="paciente_id" id="paciente_id" type="number" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div> --}}

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-500 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600">Guardar</button>
                </div>
            </form>
        </section>
    </div>

    {{--
    <section class="max-w-7xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800 mt-20">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Tabla Tratamiento</h2>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th scope="col" class="px-4 py-3">Profesional que realizo la consulta</th>
                        <th scope="col" class="px-4 py-3">Consumo de Fármacos</th>
                        <th scope="col" class="px-4 py-3">Antecedente Familiar</th>
                        <th scope="col" class="px-4 py-3">Fecha de atencion</th>
                        <th scope="col" class="px-4 py-3">Motivo Consulta Anterior</th>

                        <th scope="col" class="px-4 py-3">Indicación Terapéutica ID</th>
                        <th scope="col" class="px-4 py-3">Derivación Psiquiátrica ID</th>
                        <th scope="col" class="px-4 py-3">Procedencia ID</th>
                        <th scope="col" class="px-4 py-3">Enfermedad ID</th>
                        <th scope="col" class="px-4 py-3">acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tratamientos as $tratamiento)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->profesional_enterior }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->consumo_farmacos }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->antecedente_familiar }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->fecha_atencion }}</td>

                            <td class="py-2 px-4 border-b">{{ $tratamiento->motivo_consulta_anterior }}</td>


                            <td class="py-2 px-4 border-b">{{ $tratamiento->indicacionterapeuticas->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->derivacionpsiquiatricas->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->procedencias->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $tratamiento->enfermedades->name }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('patient.patient-historial', ['paciente' => $tratamiento->paciente_id, 'tratamiento' => $tratamiento->id]) }}"
                                    class="text-blue-500 hover:underline">Crear</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
 --}}


    <div class="padreTablas mt-6 flex gap-x-2 px-6 mb-6">

        <section class="seccionTab xl:mx-auto lg:mx-auto w-[75%]">
            <div class="mx-auto text-[12px]">
                <!-- Start coding here -->
                <div class="bg-gray-800  shadow-md sm:rounded-lg ">
                    <div class="flex items-center justify-between d p-4">
                        <div class="flex flex-row items-end justify-between w-full">
                            <div class="w-fit">
                                <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                            {{-- <div class="">
                                    <a href="{{route('multiform.index')}}" class="pr-3 pl-2 py-2 text-white bg-[#2d5986] rounded-md hover:text-white hover:bg-[#3973ac]">
                                        <span class="text-[20px]">+ </span>
                                        <span class="agre text-[13px]">AGREGAR</span>
                                    </a>
                                </div> --}}
                        </div>

                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="teGead text-xs text-white uppercase bg-gray-900">
                                <tr>

                                    <th scope="col" class="px-4 py-3">Profesional que realizo la consulta</th>
                                    <th scope="col" class="px-4 py-3">Consumo de Fármacos</th>
                                    <th scope="col" class="px-4 py-3">Antecedente Familiar</th>
                                    <th scope="col" class="px-4 py-3">Fecha de atencion</th>
                                    <th scope="col" class="px-4 py-3">Motivo Consulta Anterior</th>
                                    {{--  <th scope="col" class="px-4 py-3">Tipo Licencia ID</th> --}}
                                    <th scope="col" class="px-4 py-3">Indicación Terapéutica ID</th>
                                    <th scope="col" class="px-4 py-3">Derivación Psiquiátrica ID</th>
                                    {{--  --}}<th scope="col" class="px-4 py-3">Procedencia ID</th>
                                    <th scope="col" class="px-4 py-3">Enfermedad ID</th>
                                    <th scope="col" class="px-4 py-3">acciones</th>


                                </tr>
                            </thead>
                            <tbody class="">
                                @foreach ($tratamientos as $tratamiento)
                                    <tr  wire:key="{{ $tratamiento->id }}"
                                        class="border-b border-gray-700 text-[12px] hover:bg-[#204060]">


                                        <th
                                            class="tiBody px-4 py-1 font-medium text-white whitespace-nowrap dark:text-white">
                                            {{ $tratamiento->profesional_enterior }}</th>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->consumo_farmacos }}</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->antecedente_familiar }}</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->fecha_atencion }}</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->motivo_consulta_anterior}}</td>

                                        </th>
                                         <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->indicacionterapeuticas->name }}</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->derivacionpsiquiatricas->name}}</td>
                                         <td class="tiBody px-4 py-1 text-gray-300">---</td>
                                        <td class="tiBody px-4 py-1 text-gray-300">{{ $tratamiento->enfermedades->name }}</td>

                                        <td class="tiBody px-4 py-1">
                                            <button
                                                onclick="confirm('Seguro desea eliminar a este control ?') || event.stopImmediatePropagation()"
                                                wire:click="delete({{ $tratamiento->id }})"
                                                class="ml-2 px-4 py-[2px] bg-[#2d5986] hover:bg-[#3973ac] text-white rounded">Editar</button>
                                        </td>
                                        {{-- <td class="tiBody px-4 py-1">
                                            <a class="ml-3 px-4 py-1 rounded-md bg-[#2d5986] text-white  hover:bg-[#3973ac]"
                                                href="{{ route('interviews.index', ['paciente' => $paciente->id]) }}">
                                                {{ __('Ir') }}
                                            </a>
                                        </td> --}}
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
                        {{ $tratamientos->links() }}
                    </div>
                </div>
            </div>
        </section>

        {{--   <section class="seccionTab2 w-fit">@livewire('patient.patient-listfechas')</section> --}}


    </div>







</div>
