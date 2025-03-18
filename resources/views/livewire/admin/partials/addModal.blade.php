<x-jet-dialog-modal wire:model="officeAddModal">
    <x-slot name="title">
        <h1>{{ __('add new office') }}</h1>
    </x-slot>

    <x-slot name="content">

        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-2">
                <label for="local">{{ __('local') }}</label>
                <input class="w-full rounded" type="text" wire:model.defer="local">
                <x-jet-input-error for="local"/>
            </div>
            <div class="col-span-4">
                <label for="address">{{ __('address') }}</label>
                <input class="w-full rounded" type="text" wire:model.defer="address">
                <x-jet-input-error for="address"/>
            </div>
            <div class="col-span-2">
                <label for="phone">{{ __('phone') }}</label>
                <input class="w-full rounded" type="text" wire:model.defer="phone">
                <x-jet-input-error for="phone"/>
            </div>
            <div class="col-span-2">
                <label for="mobil">{{ __('mobil') }}</label>
                <input class="w-full rounded" type="text" wire:model.defer="mobil">
            </div>

            <div class="col-span-2">
                <label for="email">{{ __('email') }}</label>
                <input class="w-full rounded" type="text" wire:model.defer="email">
            </div>

            <div class="col-span-2">
                <label for="lat">{{ __('lat') }}</label>
                <input class="w-full rounded" type="text" wire:model.defer="lat">
            </div>

            <div class="col-span-2">
                <label for="lgn">{{ __('lgn') }}</label>
                <input class="w-full rounded" type="text" wire:model.defer="lgn">
            </div>

            <div class="col-span-2">
                <label for="map">{{ __('map') }}</label>
                <input class="w-full rounded" type="text" wire:model.defer="map">
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <button class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded mx-1 "
        wire:click="$set('officeAddModal',false)"
        >{{ __('cancel') }}</button>
        <button class="bg-green-500  hover:bg-green-400 text-white px-4 py-2 rounded mx-1" wire:click="addOffice">{{ __('create') }}</button>
    </x-slot>
</x-jet-dialog-modal>
