<x-dialog-modal wire:model="workdayEditModal">
    <x-slot name="title">
        <div class="flex justify-between items-center">
                <h1 class="font-bold">{{ $dia }}</h1>
                <div>
                    <input class="mx-3" type="checkbox" wire:model="active">
                    {{ __('activo') }}
                </div>
        </div>
    </x-slot>
    <x-slot name="content">
        <h1 class="font-bold py-2 capitalize">{{ __('mañana') }}</h1>
        @include('livewire.doctor.partials.morning')
        <h1 class="font-bold py-2 capitalize">{{ __('tarde') }}</h1>
        @include('livewire.doctor.partials.afternoon')
       {{--  <h1 class="font-bold py-2 capitalize">{{ __('noche') }}</h1>
        @include('livewire.doctor.partials.evening') --}}
    </x-slot>
    <x-slot name="footer">
        <button class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded mx-1 "
            wire:click="$set('workdayEditModal',false)">{{ __('cancelar') }}</button>
        <button class="bg-green-500  hover:bg-green-400 text-white px-4 py-2 rounded mx-1"
        wire:click="update({{ $day }})">{{ __('actualizar') }}</button>
    </x-slot>
</x-dialog-modal>
