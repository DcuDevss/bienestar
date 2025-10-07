<div>
    @if (session()->has('success'))
    <div class="mb-2 px-4 py-2 bg-green-600 text-white rounded-md text-center">
        {{ session('success') }}
    </div>
    @endif

    <header class="px-3  bg-white">
        <h2 class="font-bold text-center text-gray-800  text-2xl mb-2 flex items-center">
            {{-- <span class="text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
            </span> --}}
            <div>
                <img src="https://cdn-icons-png.flaticon.com/512/2522/2522570.png" alt="" class="h-[34px]">
            </div>
            <span class="font-bold  text-sm text-gray-500 space-x-2">
                {{ __('Historial de enfermedades') }}
            </span>
        </h2>
        <ul class="w-full">
            <input class="w-full rounded" type="text" placeholder="buscar enfermedad o crearla"
                wire:model.live="search" />
            {{--  --}} @foreach ($patient->enfermedades as $pd)
                <li class="mb-1">
                    <div class="flex justify-between items-center">
                        {{--  <span
                            class="cursor-pointer rounded-md px-2 py-1 bg-slate-800 hover:bg-slate-900 text-white">{{ $pd->name }}</span>

                        </span> --}}
                    </div>
                </li>
            @endforeach
        </ul>
    </header>
    <div class="bg-white px-3">

        {{--  <ul class="w-full">

            @forelse($enfermedades as $enfermedad)
                <li class="cursor-pointer px-2 py-1 bg-gray-400 hover:bg-gray-500 text-black my-2 bolck rounded-md"><a
                        wire:click="addModalDisase({{ $enfermedad->id }})">{{ $enfermedad->name }}:
                        </a></li>
            @empty
                @if (strlen(trim($this->search)) > 4)
                    <h3 class="bg-red-500 text-white p-2 w-full mt-2 text-center font-bold">
                        {{ __('no search result') }}</h3>
                    <div class="bg-blue-500 text-white text-center p-2 my-2">
                        <button wire:click="addNew">{{ __(' quires agregar esta nueva enfermedad?') }}
                            <br>
                            <strong class="text-xl">{{ __($this->search) }}</strong>
                            <br>
                            <p>{{ __('listar ...?') }}</p>
                        </button>

                    </div>
                @endif
            @endforelse
        </ul> --}}
        <ul class="w-full">
            @forelse($enfermedades as $enfermedad)
                <li class="cursor-pointer px-3 py-2 bg-gray-400 hover:bg-gray-500 text-black my-2 bolck rounded-md">
                    <a
                        wire:click="addModalDisase({{ $enfermedad->id }})">{{ $enfermedad->codigo }}-{{ $enfermedad->name }}</a>
                </li>
            @empty
                @if (strlen(trim($this->search)) > 4)
                    <div class="bg-[#dc2626] text-white text-center p-1 rounded-md text-sm">
                        <span>Sin resultados, desea agregarla como nueva enfermedad?</span>
                        {{--<strong class="">{{ __($this->searchsdf) }}</strong>--}}
                        <div>
                            <button wire:click="addNew" class="text-black bg-white px-2 py-1 rounded-md hover:bg-[#d1d5db]">
                                <p>{{ __('Si') }}</p>
                            </button>
                            {{-- <button wire:click="$set(exit)"
                                 class="text-black bg-white px-2 py-1 rounded-md hover:bg-[#d1d5db]">
                                {{ __('No') }}
                            </button> --}}
                        </div>
                    </div>
                @endif
            @endforelse
        </ul>

    </div>

    @if ($modal)
        <div class="bg-gray-800 bg-opacity-65 fixed  inset-0 z-10">
            <div class="p-6">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

                    <div class="bg-white shadow rounded-lg p-6">

                        {{--  <form wire:submit="update"></form> --}}


                        <div class="grid grid-cols-3 gap-4">
                            <div class="relative"
                                wire:click.outside="closePicker"
                                wire:keydown.escape="closePicker">

                            <label for="diag-search" class="block text-sm font-medium text-gray-700">
                                {{ __('Nombre del diagnostico') }}
                            </label>

                            <input id="diag-search"
                                    class="w-full rounded bg-gray-200"
                                    type="text"
                                    placeholder="{{ __('buscar enfermedad o crearla') }}"
                                    wire:model.live="search"
                                    x-data @focus="$wire.openPicker()" />

                            <x-input-error for="name" />

                            @if ($pickerOpen && trim($search) !== '')
                                <div class="absolute left-0 right-0 z-50 mt-1 max-h-64 overflow-y-auto
                                            bg-white border border-slate-200 rounded-md shadow">
                                <ul class="w-full">
                                    @forelse($enfermedades as $enfermedad)
                                    <li class="cursor-pointer px-3 py-2 bg-gray-100 hover:bg-gray-200 text-black my-1 rounded-md">
                                        <button type="button" class="w-full text-left"
                                                wire:click="pickEnfermedad({{ $enfermedad->id }})">
                                        {{ $enfermedad->codigo }}-{{ $enfermedad->name }}
                                        </button>
                                    </li>
                                    @empty
                                    @if (strlen(trim($search)) > 4)
                                        <div class="bg-[#dc2626] text-white text-center p-2 rounded-md text-sm">
                                        <span>Sin resultados, ¿desea agregarla como nueva enfermedad?</span>
                                        <div class="mt-1">
                                            <button wire:click="addNew"
                                                    class="text-black bg-white px-2 py-1 rounded-md hover:bg-gray-200">
                                            {{ __('Si') }}
                                            </button>
                                        </div>
                                        </div>
                                    @endif
                                    @endforelse
                                </ul>
                                </div>
                            @endif
                            </div>



                            <div>
                                <label for="tipodelicencia"
                                    class="block text-sm font-medium text-gray-700">{{ __('Tipo de Licencia') }}</label>
                                <select id="tipodelicencia" class="w-full rounded cursor-pointer"
                                    wire:model="tipodelicencia">
                                    <option value="" selected>{{ __('Seleccione una opción') }}</option>
                                    <option value="Enfermedad común">{{ __('Enfermedad común') }}</option>
                                    <option value="Enfermedad largo tratamiento">
                                        {{ __('Enfermedad largo tratamiento') }}</option>
                                    <option value="Atención familiar">{{ __('Atención familiar') }}</option>
                                    <option value="Donación de sangre">{{ __('Donación de sangre') }}</option>
                                    <option value="Maternidad">{{ __('Maternidad') }}</option>
                                    <option value="Nacimiento trabajo">{{ __('Nacimiento trabajo') }}</option>
                                    <option value="Salud embarazo">{{ __('Salud embarazo') }}</option>
                                    <option value="Licencia pandemia">{{ __('Licencia pandemia') }}</option>
                                    <option value="Dto. 564/18 lic. extraordinaria ley 911-art 9">
                                        {{ __('Dto. 564/18 lic. extraordinaria ley 911-art 9') }}</option>
                                </select>
                                <x-input-error for="tipodelicencia" />
                            </div>

                            <div>
                                <label for="derivacion_psiquiatrica"
                                    class="block text-sm font-medium text-gray-700">{{ __('Derivacion psiquiatrica') }}</label>
                                <select id="derivacion_psiquiatrica" class="w-full rounded cursor-pointer"
                                    wire:model="derivacion_psiquiatrica">
                                    <option value="" selected>{{ __('Seleccione una opción') }}</option>
                                    <option value="no">{{ __('no') }}</option>
                                    <option value="si">{{ __('si') }}</option>
                                </select>
                                <x-input-error for="derivacion_psiquiatrica" />
                            </div>

                        </div>
                        <div class="col-span-2 mt-3">
                            <label for="motivo_consulta"
                                class="block text-sm font-medium text-gray-700">{{ __('motivo de consulta') }}</label>
                            <textarea id="motivo_consulta" class="w-full rounded cursor-pointer" rows="3"
                                placeholder="{{ __('ingrese detalle') }}" wire:model="motivo_consulta"></textarea>
                            <x-input-error for="motivo_consulta" />
                        </div>

                        <div class="grid grid-cols-3 gap-4 mt-3">


                            <div>
                                <label for="fecha_atencion_enfermedad"
                                    class="block text-sm font-medium text-gray-700">{{ __('Fecha de atencion medica') }}</label>
                                <input id="fecha_atencion_enfermedad" class="w-full rounded cursor-pointer"
                                    type="datetime-local" placeholder="{{ __('fecha de inicio') }}"
                                    wire:model="fecha_atencion_enfermedad" />
                                <x-input-error for="fecha_atencion_enfermedad" />
                            </div>

                            <div>
                                <label for="fecha_finalizacion_enfermedad"
                                    class="block text-sm font-medium text-gray-700">{{ __('finalización de enfermedad') }}</label>
                                <input id="fecha_finalizacion_enfermedad" class="w-full rounded cursor-pointer"
                                    type="datetime-local" placeholder="{{ __('fecha finalización') }}"
                                    wire:model="fecha_finalizacion_enfermedad" />
                                <x-input-error for="fecha_finalizacion_enfermedad" />
                            </div>

                            <div>
                                <label for="horas_reposo"
                                    class="block text-sm font-medium text-gray-700">{{ __('Horas de reposo') }}</label>
                                <input id="horas_reposo" class="w-full rounded cursor-pointer" type="number"
                                    placeholder="{{ __('ingrese horas de salud') }}" wire:model="horas_reposo" />
                                <x-input-error for="horas_reposo" />
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mt-3">
                            <div>
                                <label for="imgen_enfermedad"
                                    class="block text-sm font-medium text-gray-700">{{ __('imagenes') }}</label>
                                <input id="imgen_enfermedad" class="rounded py-2 cursor-pointer" type="file"
                                    wire:model="imgen_enfermedad" accept="image/*" />
                                <x-input-error for="imgen_enfermedad" />
                            </div>

                            <div>
                                <label for="pdf_enfermedad"
                                    class="block text-sm font-medium text-gray-700">{{ __('pdf') }}</label>
                                <input id="pdf_enfermedad" class="rounded py-2 cursor-pointer" type="file"
                                    wire:model="pdf_enfermedad" accept="image/*" />
                                <x-input-error for="pdf_enfermedad" />
                            </div>

                            <div>
                                <label for="art"
                                    class="block text-sm font-medium text-gray-700">{{ __('art') }}</label>
                                <input id="art" class="w-full rounded cursor-pointer" type="text"
                                    placeholder="{{ __('ingrese art') }}" wire:model="art" />
                                <x-input-error for="art" />
                            </div>
                        </div>


                        <div class="col-span-2 mt-3">
                            <label for="detalle_diagnostico"
                                class="block text-sm font-medium text-gray-700">{{ __('detalle del diagnostico') }}</label>
                            <textarea id="detalle_diagnostico" class="w-full rounded cursor-pointer" rows="3"
                                placeholder="{{ __('ingrese detalle') }}" wire:model="detalle_diagnostico"></textarea>
                            <x-input-error for="detalle_diagnostico" />
                        </div>

                        <div class="grid grid-cols-4 gap-4 mt-3">
                            <div>
                                <label for="medicacion"
                                    class="block text-sm font-medium text-gray-700">{{ __('medicacion') }}</label>
                                <input id="medicacion" class="w-full rounded cursor-pointer" type="text"
                                    placeholder="{{ __('ingrese horas de salud') }}" wire:model="medicacion" />
                                <x-input-error for="medicacion" />
                            </div>

                            <div>
                                <label for="dosis"
                                    class="block text-sm font-medium text-gray-700">{{ __('dosis') }}</label>
                                <input id="dosis" class="w-full rounded cursor-pointer" type="text"
                                    placeholder="{{ __('ingrese horas de salud') }}" wire:model="dosis" />
                                <x-input-error for="dosis" />
                            </div>

                            <div>
                                <label for="nro_osef"
                                    class="block text-sm font-medium text-gray-700">{{ __('nro de remedio osef') }}</label>
                                <input id="nro_osef" class="w-full rounded cursor-pointer" type="text"
                                    placeholder="{{ __('ingrese nro de remedio') }}" wire:model="nro_osef" />
                                <x-input-error for="nro_osef" />

                            </div>
{{--
                            <div>
                                <label for="estado_enfermedad"
                                    class="block text-sm font-medium text-gray-700">{{ __('estado de la enfermedad') }}</label>
                                <input id="estado_enfermedad" class="rounded cursor-pointer" type="checkbox"
                                    wire:model="estado_enfermedad" />
                                <x-input-error for="estado_enfermedad" />
                            </div> --}}
                        </div>

                        {{--
                        <div class="col-span-2 mt-3">
                            <label for="detalle_medicacion"
                                class="block text-sm font-medium text-gray-700">{{ __('detalle de la medicacion') }}</label>
                            <textarea id="detalle_medicacion" class="w-full rounded cursor-pointer" rows="5"
                                placeholder="{{ __('ingrese detalle') }}" wire:model="detalle_medicacion"></textarea>
                            <x-input-error for="detalle_medicacion" />
                        </div> --}}

                        <div class="mt-4 text-right">
                            <button class="bg-red-500 text-white hover:bg-red-400 px-4 py-2 rounded "
                                wire:click="$set('modal',false)">
                                {{ __('cancelar') }}
                            </button>
                            <button class="bg-green-500 text-white hover:bg-green-400 px-4 py-2 rounded "
                                wire:click="addDisase">
                                {{ __('agregar enfermedad') }}
                            </button>
                        </div>

                        <input type="hidden" wire:model="enfermedade_id">


                    </div>

                </div>

            </div>

        </div>
    @endif


    {{--
    <x-dialog-modal wire:model="modal">

        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('agregar afeccion al historial del paciente') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/especialidades.jpg') }}" alt="">
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="name"
                        class="block text-sm font-medium text-gray-700">{{ __('Nombre del diagnostico') }}</label>
                    <input id="name" class="w-full rounded cursor-not-allowed bg-gray-200" type="text"
                        placeholder="{{ __('nombre') }}" wire:model="name" disabled />
                    <x-input-error for="name" />
                </div>

                <div>
                    <label for="tipodelicencia"
                        class="block text-sm font-medium text-gray-700">{{ __('Tipo de Licencia') }}</label>
                    <select id="tipodelicencia" class="w-full rounded cursor-pointer" wire:model="tipodelicencia">
                        <option value="" selected>{{ __('Seleccione una opción') }}</option>
                        <option value="Enfermedad común">{{ __('Enfermedad común') }}</option>
                        <option value="Enfermedad largo tratamiento">{{ __('Enfermedad largo tratamiento') }}</option>
                        <option value="Atención familiar">{{ __('Atención familiar') }}</option>
                        <option value="Donación de sangre">{{ __('Donación de sangre') }}</option>
                        <option value="Maternidad">{{ __('Maternidad') }}</option>
                        <option value="Nacimiento trabajo">{{ __('Nacimiento trabajo') }}</option>
                        <option value="Salud embarazo">{{ __('Salud embarazo') }}</option>
                        <option value="Licencia pandemia">{{ __('Licencia pandemia') }}</option>
                        <option value="Dto. 564/18 lic. extraordinaria ley 911-art 9">
                            {{ __('Dto. 564/18 lic. extraordinaria ley 911-art 9') }}</option>
                    </select>
                    <x-input-error for="tipodelicencia" />
                </div>

                <div>
                    <label for="derivacion_psiquiatrica"
                        class="block text-sm font-medium text-gray-700">{{ __('Derivacion psiquiatrica') }}</label>
                    <select id="derivacion_psiquiatrica" class="w-full rounded cursor-pointer" wire:model="derivacion_psiquiatrica">
                        <option value="" selected>{{ __('Seleccione una opción') }}</option>
                        <option value="no">{{ __('no') }}</option>
                        <option value="si">{{ __('si') }}</option>
                    </select>
                    <x-input-error for="derivacion_psiquiatrica" />
                </div>

                <div>
                    <label for="estado_enfermedad"
                        class="block text-sm font-medium text-gray-700">{{ __('estado de la enfermedad') }}</label>
                    <input id="estado_enfermedad" class="rounded cursor-pointer" type="checkbox"
                         wire:model="estado_enfermedad" />
                    <x-input-error for="estado_enfermedad" />
                </div>

            </div>
            <div class="col-span-2 mt-3">
                <label for="motivo_consulta"
                    class="block text-sm font-medium text-gray-700">{{ __('motivo_consulta') }}</label>
                <textarea id="motivo_consulta" class="w-full rounded cursor-pointer" rows="5"
                    placeholder="{{ __('ingrese detalle') }}" wire:model="motivo_consulta"></textarea>
                <x-input-error for="motivo_consulta" />
            </div>

            <div class="grid grid-cols-3 gap-4 mt-3">


                <div>
                    <label for="fecha_atencion_enfermedad"
                        class="block text-sm font-medium text-gray-700">{{ __('Fecha de atencion medica') }}</label>
                    <input id="fecha_atencion_enfermedad" class="w-full rounded cursor-pointer" type="datetime-local"
                        placeholder="{{ __('fecha de inicio') }}" wire:model="fecha_atencion_enfermedad" />
                    <x-input-error for="fecha_atencion_enfermedad" />
                </div>

                <div>
                    <label for="fecha_finalizacion_enfermedad"
                        class="block text-sm font-medium text-gray-700">{{ __('finalización de enfermedad') }}</label>
                    <input id="fecha_finalizacion_enfermedad" class="w-full rounded cursor-pointer"
                        type="datetime-local" placeholder="{{ __('fecha finalización') }}"
                        wire:model="fecha_finalizacion_enfermedad" />
                    <x-input-error for="fecha_finalizacion_enfermedad" />
                </div>

                <div>
                    <label for="horas_reposo"
                        class="block text-sm font-medium text-gray-700">{{ __('Horas de reposo') }}</label>
                    <input id="horas_reposo" class="w-full rounded cursor-pointer" type="number"
                        placeholder="{{ __('ingrese horas de salud') }}" wire:model="horas_reposo" />
                    <x-input-error for="horas_reposo" />
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mt-3">
                <div>
                    <label for="imgen_enfermedad"
                        class="block text-sm font-medium text-gray-700">{{ __('imagenes') }}</label>
                    <input id="imgen_enfermedad" class="rounded py-2 cursor-pointer" type="file"
                        wire:model="imgen_enfermedad" accept="image/*" />
                    <x-input-error for="imgen_enfermedad" />
                </div>

                <div>
                    <label for="pdf_enfermedad"
                        class="block text-sm font-medium text-gray-700">{{ __('pdf') }}</label>
                    <input id="pdf_enfermedad" class="rounded py-2 cursor-pointer" type="file"
                        wire:model="pdf_enfermedad" accept="image/*" />
                    <x-input-error for="pdf_enfermedad" />
                </div>

                <div>
                    <label for="art"
                        class="block text-sm font-medium text-gray-700">{{ __('art') }}</label>
                    <input id="art" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('ingrese art') }}" wire:model="art" />
                    <x-input-error for="art" />
                </div>
            </div>


            <div class="col-span-2 mt-3">
                <label for="detalle_diagnostico"
                    class="block text-sm font-medium text-gray-700">{{ __('detalle del diagnostico') }}</label>
                <textarea id="detalle_diagnostico" class="w-full rounded cursor-pointer" rows="5"
                    placeholder="{{ __('ingrese detalle') }}" wire:model="detalle_diagnostico"></textarea>
                <x-input-error for="detalle_diagnostico" />
            </div>

            <div class="grid grid-cols-3 gap-4 mt-3">
                <div>
                    <label for="medicacion"
                        class="block text-sm font-medium text-gray-700">{{ __('medicacion') }}</label>
                    <input id="medicacion" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('ingrese horas de salud') }}" wire:model="medicacion" />
                    <x-input-error for="medicacion" />
                </div>

                <div>
                    <label for="dosis" class="block text-sm font-medium text-gray-700">{{ __('dosis') }}</label>
                    <input id="dosis" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('ingrese horas de salud') }}" wire:model="dosis" />
                    <x-input-error for="dosis" />
                </div>

                <div>
                    <label for="nro_osef"
                        class="block text-sm font-medium text-gray-700">{{ __('nro de remedio osef') }}</label>
                    <input id="nro_osef" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('ingrese nro de remedio') }}" wire:model="nro_osef" />
                    <x-input-error for="nro_osef" />
                </div>

                <div class="col-span-2 mt-3">
                <label for="detalle_medicacion"
                    class="block text-sm font-medium text-gray-700">{{ __('detalle de la medicacion') }}</label>
                <input id="detalle_medicacion" class="w-full rounded cursor-pointer" rows=""
                    placeholder="{{ __('ingrese detalle') }}" wire:model="detalle_medicacion"></input>
                <x-input-error for="detalle_medicacion" />
            </div>


            </div>


            <input type="hidden" wire:model="enfermedade_id">
        </x-slot>


        <x-slot name="footer">
            <button class="bg-red-500 text-white hover:bg-red-400 px-4 py-2 rounded mx-3"
                wire:click="$set('modal',false)">
                {{ __('cancelar') }}
            </button>
            <button class="bg-green-500 text-white hover:bg-green-400 px-4 py-2 rounded mx-3" wire:click="addDisase">
                {{ __('agregar enfermedad') }}
            </button>

        </x-slot>
    </x-dialog-modal> --}}
</div>

{{-- <div class="col-span-2 mt-3">
                <label for="detalle_medicacion"
                    class="block text-sm font-medium text-gray-700">{{ __('detalle de la medicacion') }}</label>
                <input id="detalle_medicacion" class="w-full rounded cursor-pointer" rows=""
                    placeholder="{{ __('ingrese detalle') }}" wire:model="detalle_medicacion"></input>
                <x-input-error for="detalle_medicacion" />
            </div> --}}
