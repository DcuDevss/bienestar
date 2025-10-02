<div>

    <header class="px-3 bg-white">
        <h2 class="font-bold text-center text-gray-800 capitalize text-2xl mb-2 flex items-center">
            <div class="">
                <img src="https://cdn-icons-png.flaticon.com/512/3216/3216342.png" alt="" class="h-[34px]">
            </div>
            <span class="font-bold ml-1 text-sm  text-gray-500">
                {{ __('Historial de certificados') }}
            </span>
        </h2>
        <ul class="w-full">
            <input class="w-full rounded" type="text" placeholder="buscar patologia de certificados o crearla"
                wire:model.live="search" />
            @foreach ($patient->disases as $pd)
                <li class="mb-1">
                    <div class="flex justify-between items-center">
                        {{-- <span class="cursor-pointer rounded-md px-2 py-1 bg-slate-800 hover:bg-slate-900 text-white">{{ $pd->name }}</span>
                        <span class="text-gray-500">
                            {{ $pd->pivot->fecha_enfermedad }} - {{ $pd->pivot->tipo_enfermedad }}
                        </span>  --}}
                    </div>
                </li>
            @endforeach
        </ul>
    </header>
    <div class="bg-white px-3 pt-1">

        <ul class="w-full">
            @forelse($disases as $disase)
                <li class="cursor-pointer px-3 py-2 bg-gray-400 hover:bg-gray-500 text-black my-2 bolck rounded-md">
                    <a wire:click="addModalDisase({{ $disase->id }})">{{ $disase->name }}</a>
                </li>
            @empty
                @if (strlen(trim($this->search)) > 4)
                    <div class="bg-[#dc2626] text-white text-center p-1 rounded-md text-sm">
                        <span>Sin resultados, desea agregarla como nueva patologia de certificado?</span>
                        {{-- <strong class="text-xl">{{ __($this->search) }}</strong> --}}
                        <div>
                            <button wire:click="addNew"
                                class="text-black bg-white px-2 py-1 rounded-md hover:bg-[#d1d5db]">
                                {{ __('Si') }}
                            </button>
                            {{--  <button wire:click="cancel" class="text-black bg-white px-2 py-1 rounded-md hover:bg-[#d1d5db]">
                                {{ __('No') }}
                            </button> --}}
                        </div>
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
                <div class="relative" wire:click.outside="closePicker" wire:keydown.escape="closePicker">

                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>

                    {{-- usá search o name; acá uso "search" --}}
                    <input id="name" class="w-full rounded bg-gray-100" type="text"
                        placeholder="{{ __('nombre') }}" wire:model.live="search" x-data @focus="$wire.openPicker()" />

                    <x-input-error for="name" />

                    @if ($pickerOpen && trim($search) !== '')
                        <div
                            class="absolute left-0 right-0 z-50 mt-1 max-h-64 overflow-y-auto bg-white border border-slate-200 rounded-md shadow">
                            <ul class="w-full">
                                @forelse($disases as $d)
                                    <li
                                        class="cursor-pointer px-3 py-2 bg-gray-50 hover:bg-gray-100 text-black my-1 rounded-md">
                                        <button type="button" class="w-full text-left"
                                            wire:click="pickDisase({{ $d->id }})">
                                            {{ $d->name }}
                                        </button>
                                    </li>
                                @empty
                                    @if (strlen(trim($search)) > 4)
                                        <div class="bg-red-600 text-white text-center p-2 rounded-md text-sm">
                                            <span>Sin resultados, ¿agregar como nueva?</span>
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
                    <label for="name"
                        class="block text-sm font-medium text-gray-700">{{ __('Tipo de Licencia') }}</label>
                    <select id="tipolicencia_id" class="w-full rounded cursor-pointer" wire:model="tipolicencia_id">
                        <option value="" selected>{{ __('Seleccione una opción') }}</option>
                        @foreach ($tipolicencias as $licencia)
                            <option value="{{ $licencia->id }}">{{ $licencia->name }}</option>
                        @endforeach
                    </select>
                </div>
                <x-input-error for="tipolicencia_id" />




                <div>
                    <label for="fecha_presentacion_certificado"
                        class="block text-sm font-medium text-gray-700">{{ __('Fecha de presentacion del certificado') }}</label>
                    <input id="fecha_presentacion_certificado" class="w-full rounded cursor-pointer" type="date"
                        placeholder="{{ __(' ingrese fecha de la enfermedad') }}"
                        wire:model="fecha_presentacion_certificado" />
                    <x-input-error for="fecha_presentacion_certificado" />
                </div>

                {{-- Nuevos campos --}}
                <div>
                    <label for="fecha_inicio_licencia"
                        class="block text-sm font-medium text-gray-700">{{ __('Inicio del certificado') }}</label>
                    <input id="fecha_inicio_licencia" class="w-full rounded cursor-pointer" type="datetime-local"
                        placeholder="{{ __('fecha de inicio') }}" wire:model="fecha_inicio_licencia" />
                    <x-input-error for="fecha_inicio_licencia" />
                </div>

                <div>
                    <label for="fecha_finalizacion_licencia"
                        class="block text-sm font-medium text-gray-700">{{ __('Finalización de certificado') }}</label>
                    <input id="fecha_finalizacion_licencia" class="w-full rounded cursor-pointer" type="datetime-local"
                        placeholder="{{ __('fecha finalización') }}" wire:model="fecha_finalizacion_licencia" />
                    <x-input-error for="fecha_finalizacion_licencia" />
                </div>

                <div>
                    <label for="horas_salud"
                        class="block text-sm font-medium text-gray-700">{{ __('Horas de licencias medica') }}</label>
                    <input id="horas_salud" class="w-full rounded cursor-pointer" type="number"
                        placeholder="{{ __('ingrese horas de salud') }}" wire:model="horas_salud" />
                    <x-input-error for="horas_salud" />
                </div>

                <div class="mb-4">
                    <label for="suma_salud" class="block text-sm font-medium text-gray-700">
                        Días licencia certificado
                    </label>
                    <input type="number" wire:model="suma_salud" id="suma_auxiliar" readonly
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Días calculados automáticamente">
                    @error('suma_salud')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="imagen_frente"
                        class="block text-sm font-medium text-gray-700">{{ __('Imagen frente') }}</label>
                    <input id="imagen_frente" class="rounded py-2 cursor-pointer" type="file"
                        wire:model="imagen_frente" accept="image/*" />
                    <x-input-error for="imagen_frente" />
                </div>

                <div>
                    <label for="imagen_dorso"
                        class="block text-sm font-medium text-gray-700">{{ __('Imagen dorso') }}</label>
                    <input id="imagen_dorso" class="rounded py-2 cursor-pointer" type="file"
                        wire:model="imagen_dorso" accept="image/*" />
                    <x-input-error for="imagen_dorso" />
                </div>

                <div class="col-span-2">
                    <label for="detalle_certificado"
                        class="block text-sm font-medium text-gray-700">{{ __('Detalle del certificado') }}</label>
                    <textarea id="detalle_certificado" class="w-full rounded cursor-pointer" rows="5"
                        placeholder="{{ __('ingrese detalle') }}" wire:model="detalle_certificado"></textarea>
                    <x-input-error for="detalle_certificado" />
                </div>
            </div>
            <input type="hidden" wire:model="disase_id">
        </x-slot>

        <x-slot name="footer">
            @if (session('error'))
                <div class="bg-red-500 text-white p-3 rounded-lg mb-4" style="font-size: 14px;">
                    {{ session('error') }}
                </div>
            @endif

            <button class="bg-red-500 text-white hover:bg-red-400 px-4 py-2 rounded mx-3"
                wire:click="$set('modal',false)">
                {{ __('Cancelar') }}
            </button>
            <button class="bg-green-500 text-white hover:bg-green-400 px-4 py-2 rounded mx-3" wire:click="addDisase">
                {{ __('Agregar enfermedad') }}
            </button>

        </x-slot>
    </x-dialog-modal>
</div>
