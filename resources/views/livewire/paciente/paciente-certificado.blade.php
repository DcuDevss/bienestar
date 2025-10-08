<div>
    <header class="px-5 py-4 border-b border-gray-100 bg-white">
        <h2 class="font-bold text-center text-gray-800 capitalize text-2xl mb-2 flex items-center">
            <span class="text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
            </span>
            <span class="font-bold ml-4 text-sm float-left text-gray-500">
                {{ __('Historial de certificados') }}
            </span>
        </h2>
        <ul class="w-full">
            <input class="w-full rounded mb-4" type="text" placeholder="buscar enfermedad o crearla" wire:model.live="search" />
            @foreach ($patient_enfermedades as $pd)
                <li class="mb-1">
                    <div class="flex justify-between items-center">
                        <span
                            class="cursor-pointer rounded-md px-2 py-1 bg-slate-800 hover:bg-slate-900 text-white">{{ $pd->enfermedad->name }}</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </header>
    <div class="bg-white p-3">
        <ul class="w-full">
            @forelse($enfermedades as $enfermedad)
                <li class="cursor-pointer px-3 py-2 bg-gray-400 hover:bg-gray-500 text-black my-2 bolck"><a
                        wire:click="addModalEnfermedade({{ $enfermedad->id }})">{{ $enfermedad->name }}</a></li>
            @empty
                @if (strlen(trim($this->search)) > 5)
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
        </ul>
    </div>

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('agregar certificado al historial del paciente') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/disases.jpg') }}" alt="">
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>
                    <input id="name" class="w-full rounded cursor-not-allowed bg-gray-200" type="text"
                        placeholder="{{ __('nombre') }}" wire:model="name" disabled />
                    <x-input-error for="name" />
                </div>

              {{--   <div>
                    <label for="tipodelicencia" class="block text-sm font-medium text-gray-700">{{ __('Tipo de Licencia') }}</label>
                    <select id="tipodelicencia" class="w-full rounded cursor-pointer" wire:model="tipodelicencia">
                        <option value="" selected>{{ __('Seleccione una opción') }}</option>
                        <option value="Enfermedad común">{{ __('Enfermedad común') }}</option>
                        <option value="Enfermedad largo tratamiento">{{ __('Enfermedad largo tratamiento') }}</option>
                        <!-- Otras opciones del tipo de licencia -->
                    </select>
                    <x-input-error for="tipodelicencia" />
                </div>

                <div>
                    <label for="fecha_enfermedad"
                        class="block text-sm font-medium text-gray-700">{{ __('fecha de presentacion del certificado') }}</label>
                    <input id="fecha_enfermedad" class="w-full rounded cursor-pointer" type="date"
                        placeholder="{{ __(' ingrese fecha de la enfermedad') }}" wire:model="fecha_enfermedad" />
                    <x-input-error for="fecha_enfermedad" />
                </div>--}}

                <!-- Nuevos campos -->


                {{----}}  <div>
                    <label for="fecha_atencion2"
                        class="block text-sm font-medium text-gray-700">{{ __('inicio del certificado') }}</label>
                    <input id="fecha_atencion2" class="w-full rounded cursor-pointer" type="datetime-local"
                        placeholder="{{ __('fecha de inicio') }}" wire:model="fecha_atencion2" />
                    <x-input-error for="fecha_atencion2" />
                </div>
                 {{--
                <div>
                    <label for="fecha_finalizacion"
                        class="block text-sm font-medium text-gray-700">{{ __('finalización de certificado') }}</label>
                    <input id="fecha_finalizacion" class="w-full rounded cursor-pointer" type="datetime-local"
                        placeholder="{{ __('fecha finalización') }}" wire:model="fecha_finalizacion" />
                    <x-input-error for="fecha_finalizacion" />
                </div>  --}}

                <div>
                    <label for="horas_reposo2"
                        class="block text-sm font-medium text-gray-700">{{ __('Horas de licencias medica') }}</label>
                    <input id="horas_reposo2" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('ingrese horas de salud') }}" wire:model="horas_reposo2" />
                    <x-input-error for="horas_reposo2" />
                </div>
                {{--
                <div>
                    <label class="flex items-center">
                        <input id="activo" class="rounded cursor-pointer" type="checkbox" wire:model="activo" />
                        <span class="ml-2">{{ __('Activo') }}</span>
                    </label>
                </div>

                <div>
                    <label for="archivo" class="block text-sm font-medium text-gray-700">{{ __('Archivo') }}</label>
                    <input id="archivo" class="rounded py-2 cursor-pointer" type="file" wire:model="archivo"
                        accept="image/*" />
                    <x-input-error for="archivo" />
                </div> --}}

                <div class="col-span-2">
                    <label for="detalle_enfermedad2"
                        class="block text-sm font-medium text-gray-700">{{ __('detalle del certificado') }}</label>
                    <textarea id="tipo_enfermedad" class="w-full rounded cursor-pointer" rows="5"
                        placeholder="{{ __('ingrese detalle') }}" wire:model="detalle_enfermedad2"></textarea>
                    <x-input-error for="detalle_enfermedad2" />
                </div>
            </div>
            <input type="hidden" wire:model="enfermedade_id">
        </x-slot>

        <x-slot name="footer">
    <button class="bg-red-500 text-white hover:bg-red-400 px-4 py-2 rounded mx-3"
        wire:click="$set('modal', false)">
        {{ __('cancelar') }}
    </button>

    @if ($certificado_id)
        <button class="bg-yellow-500 text-white hover:bg-yellow-400 px-4 py-2 rounded mx-3"
            wire:click="updateEnfermedade">
            {{ __('actualizar enfermedad') }}
        </button>
    @else
        <button class="bg-green-500 text-white hover:bg-green-400 px-4 py-2 rounded mx-3"
            wire:click="addEnfermedade">
            {{ __('agregar enfermedad') }}
        </button>
    @endif
</x-slot>

    </x-dialog-modal>

</div>
