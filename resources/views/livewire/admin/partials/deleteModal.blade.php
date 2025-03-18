<x-jet-dialog-modal wire:model="officeDeleteModal">
    <x-slot name="title">
        <h1>{{ __('delete office') }}</h1>
    </x-slot>

    <x-slot name="content">
      <h1>{{ __('you want to delete the record ').$local.'   address:'.$address }}</h1>

    </x-slot>

    <x-slot name="footer">
        <button class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded mx-1 "
        wire:click="$set('officeDeleteModal',false)"
        >{{ __('cancel') }}</button>
        <button class="bg-green-500  hover:bg-green-400 text-white px-4 py-2 rounded mx-1" wire:click="delOffice">{{ __('delete') }}</button>
    </x-slot>
</x-jet-dialog-modal>
