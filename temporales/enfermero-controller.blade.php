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
                {{ __('control paciente ') }}
            </span>
        </h2>
        <ul class="w-full">
            <input class="w-full rounded mb-4" type="text" placeholder="buscar presion arterial o crear" wire:model.live="search" />
            @foreach ($patient->enfermeros as $pd)
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
    <div class="bg-white p-3">

        <ul class="w-full">
            @forelse($enfermeros as $enfermero)
                <li class="cursor-pointer px-3 py-2 bg-gray-400 hover:bg-gray-500 text-black my-2 bolck"><a
                        wire:click="addModalEnfermero({{ $enfermero->id }})">{{ $enfermero->presion }}</a></li>
            @empty
                @if (strlen(trim($this->search)) > 1)
                    <h3 class="bg-red-500 text-white p-2 w-full mt-2 text-center font-bold">
                        {{ __('no hay resultados') }}</h3>
                    <div class="bg-blue-500 text-white text-center p-2 my-2">
                        <button wire:click="addNew">{{ __('Presiona para agregar esta presion arterial al paciente?') }}
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
                {{ __('agregar control al paciente') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/disases.jpg') }}" alt="">
        </x-slot>
        <x-slot name="content">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="presion" class="block text-sm font-medium text-gray-700">{{ __('Presion arterial') }}</label>
                    <input id="presion" class="w-full rounded cursor-not-allowed bg-gray-200" type="text" placeholder="{{ __('presion') }}" wire:model="presion" disabled />
                    <x-input-error for="presion" />
                </div>



                <div>
                    <label for="fecha_atencion" class="block text-sm font-medium text-gray-700">{{ __('fecha de atencion') }}</label>
                    <input id="fecha_atencion" class="w-full rounded cursor-pointer" type="date" placeholder="{{ __(' ingrese fecha de la enfermedad') }}" wire:model="fecha_atencion" />
                    <x-input-error for="fecha_atencion" />
                </div>

                {{-- Nuevos campos --}}
                <div>
                    <label for="glucosa" class="block text-sm font-medium text-gray-700">{{ __('glucosa en sangre') }}</label>
                    <input id="glucosa" class="w-full rounded cursor-pointer" type="text" placeholder="{{ __('glucosa') }}" wire:model="glucosa" />
                    <x-input-error for="glucosa" />
                </div>

                <div>
                    <label for="inyectable" class="block text-sm font-medium text-gray-700">{{ __('nombre del inyectable') }}</label>
                    <input id="inyectable" class="w-full rounded cursor-pointer" type="text" placeholder="{{ __('ingrese iyectable') }}" wire:model="inyectable" />
                    <x-input-error for="inyectable" />
                </div>

                <div>
                    <label for="dosis" class="block text-sm font-medium text-gray-700">{{ __('Dosis') }}</label>
                    <input id="dosis" class="w-full rounded cursor-pointer" type="number" placeholder="{{ __('ingrese la dosis') }}" wire:model="dosis" />
                    <x-input-error for="dosis" />
                </div>



                <div class="col-span-2">
                    <label for="detalles" class="block text-sm font-medium text-gray-700">{{ __('detalle del control') }}</label>
                    <textarea id="detalles" class="w-full rounded cursor-pointer" rows="5" placeholder="{{ __('ingrese detalle') }}" wire:model="detalles"></textarea>
                    <x-input-error for="detalles" />
                </div>
            </div>
            <input type="hidden" wire:model="enfermero_id">
        </x-slot>


        <x-slot name="footer">
            <button class="bg-red-500 text-white hover:bg-red-400 px-4 py-2 rounded mx-3"
                wire:click="$set('modal',false)">
                {{ __('cancelar') }}
            </button>
            <button class="bg-green-500 text-white hover:bg-green-400 px-4 py-2 rounded mx-3" wire:click="addEnfermero">
                {{ __('agregar ') }}
            </button>

        </x-slot>
    </x-dialog-modal>
</div>

