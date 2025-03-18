<!-- resources/views/livewire/control-enfermero-table.blade.php -->
{{--
<div class="mt-4">
    @if($controles->count())
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Presion</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Atención</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Glucosa</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temperatura</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detalles</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inyectable</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosis</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($controles as $control)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $control->presion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $control->fecha_atencion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $control->glucosa }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $control->temperatura }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $control->detalles }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $control->inyectable }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $control->dosis }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay controles disponibles para mostrar.</p>
    @endif
</div>
--}}

<div class="padreTablas flex gap-x-2 px-6">

    <section class="seccionTab xl:mx-auto lg:mx-auto w-[75%]">
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
                        {{--<div class="">
                                <a href="{{route('multiform.index')}}" class="pr-3 pl-2 py-2 text-white bg-[#2d5986] rounded-md hover:text-white hover:bg-[#3973ac]">
                                    <span class="text-[20px]">+ </span>
                                    <span class="agre text-[13px]">AGREGAR</span>
                                </a>
                            </div>--}}
                    </div>

                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="teGead text-xs text-white uppercase bg-gray-900">
                            <tr>

                                <th scope="col" class="px-4 py-3">Presion</th>
                                <th scope="col" class="px-4 py-3">Glucosa</th>
                                <th scope="col" class="px-4 py-3">Temperatura</th>
                                <th scope="col" class="px-4 py-3">Inyectable</th>
                                <th scope="col" class="px-4 py-3">Dosis</th>
                                <th scope="col" class="px-4 py-3">Fecha atencion</th>
                                <th scope="col" class="px-4 py-3">Detalles</th>
                                <th scope="col" class="px-4 py-3">Accion</th>

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
                            @foreach ($controles as $paciente)
                                <tr wire:key="{{ $paciente->id }}" class="border-b border-gray-700 text-[12px] hover:bg-[#204060]">

                                    <th class="tiBody px-4 py-1 font-medium text-white whitespace-nowrap dark:text-white">{{ $paciente->presion}}</th>
                                    <td class="tiBody px-4 py-1 text-gray-300">{{ $paciente->glucosa}}</td>
                                    <td class="tiBody px-4 py-1 text-gray-300">{{ $paciente->temperatura}}</td>
                                    <td class="tiBody px-4 py-1 text-gray-300">{{ $paciente->inyectable }}</td>
                                    <td class="tiBody px-4 py-1 text-gray-300">{{ $paciente->dosis }}</td>
                                    <th class="tiBody px-4 py-1 text-gray-300">{{ $paciente->fecha_atencion }}</th>
                                    <td class="tiBody px-4 py-1 text-gray-300">{{ $paciente->detalles }}</td>

                                    <td class="tiBody px-4 py-1">
                                        <button
                                            onclick="confirm('Seguro desea eliminar a este control ?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $paciente->id }})"
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
                    {{ $controles->links() }}
                </div>
            </div>
        </div>
    </section>

   {{--   <section class="seccionTab2 w-fit">@livewire('patient.patient-listfechas')</section>--}}


</div>


</div>



