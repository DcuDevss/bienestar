<section>
    <div>
        <button class="w-full bg-green-500 text-white hover:bg-green-400 px-4 py-2" wire:click="$set('openModal',true)">
            {{ __('agregar red social') }}
        </button>
    </div>
    <x-dialog-modal wire:model="openModal" wire:submit.prevent="addSocial">
        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('agregar especialidad') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/banner-social.jpg') }}"
                alt="{{ auth()->user()->name }}">
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2">

                <div class="w-full bg-blue-400 rounded-md p-2 border-2 border-white">{{ __('red social') }}</div>
                <div class="w-full bg-blue-400 rounded-md p-2 border-2 border-white">{{ __('social').' : '. auth()->user()->name }}</div>
                <div class="aseleccionar">
                    <select class="w-full rounded" wire:model="social_id">
                        <option value="">{{__('seleccione red social') }}</option>
                        @foreach ($socials as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="seleccionadas">
                    <div>
                        <input class="w-full rounded" type="text" placeholder="{{ __('url') }}" wire:model="url"/>
                        <x-input-error for="url"/>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button class="bg-red-500 text-white hover:bg-red-400 px-4 py-2 rounded"
                wire:click="$set('openModal',false)">
                {{ __('cancel') }}
            </button>
            <button class="bg-green-500 text-white hover:bg-red-400 px-4 ml-3 py-2 rounded"
           type="submit" wire:click="addSocial">
                {{ __('ok') }}
            </button>
        </x-slot>
    </x-dialog-modal>
</section>
