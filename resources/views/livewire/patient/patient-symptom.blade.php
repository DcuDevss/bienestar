<section>
    <div>
        <button class="w-full rounded bg-blue-700 text-white hover:bg-blue-500 px-4 py-2" wire:click="$set('openModalPatient',true)">
            {{ __('agregar sintoma') }}
        </button>
    </div>
    <x-dialog-modal wire:model="openModalPatient" wire:submit.self="save">
        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('agregar sintoma') }}

            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/banner-medical.jpg') }}"
                alt="{{ auth()->user()->name }}">
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2">
                <div class="buscador col-span-2 mb-1">
                    <input class=" w-full rounded" placeholder="{{ __('buscar sintoma') }}" type="text"
                        wire:model.live="search">
                </div>
                <div class="w-full bg-blue-400 p-2 border-2 border-white text-gray-800">{{ __('sintoma') }}</div>
                <div class="w-full bg-blue-400 p-2 border-2 border-white text-gray-800">{{ auth()->user()->name }}</div>
                <div class="aseleccionar">
                    @forelse ($symptoms as $s)
                        <div>
                            <input value="{{ $s->id }}" type="checkbox" wire:change="modify({{ $s->id }})"><span class="ml-4">{{ $s->name }}</span>
                        </div>
                        @empty
                        @if (strlen(trim($this->search)) > 8)
                            <h3 class="bg-red-500 text-white p-2 w-full mt-2 text-center font-bold">
                                {{ __('no search result') }}</h3>
                            <div class="bg-blue-500 text-white text-center p-2 my-2">
                                <button wire:click="addNew">{{ __('¿ want add this') }}
                                    <br>
                                    <strong class="text-xl">{{ __($this->search) }}</strong>
                                    <br>
                                    <p>{{ __('to list ...?') }}</p>
                                </button>
                            </div>
                        @endif
                    @endforelse

                </div>
                <div class="seleccionadas">
                    @foreach ($user_symptoms as $key=>$us)
                        <div>
                            <input value="{{ $key }}" type="checkbox" wire:change="del({{ $key }})"><span class="ml-4">{{ $us }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button class="bg-yellow-500 text-white hover:bg-red-400 px-4 py-2 rounded" wire:click="$set('openModalPatient',false)">
                {{ __('cancel') }}
            </button>
            <button class="bg-green-500 text-white hover:bg-red-400 px-4 py-2 rounded mx-6" type="submit" wire:click="save">
                {{ __('ok') }}
            </button>
        </x-slot>
    </x-dialog-modal>
</section>


