<div class="grid grid-cols-3 gap-2 text-sm items-center">
    <div>
        <label for="ms">{{ __('start') }}</label>
        <select class="w-full text-sm col-span-1" wire:model="ms">
            @foreach ($morning as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-jet-input-error for="ms" />
    </div>
    <div>
        <label for="me">{{ __('end') }}</label>
        <select class="w-full text-sm col-span-1 rounded" wire:model="me">
            @foreach ($morning as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-jet-input-error for="me" />
    </div>



    <div class="col-span-1">
        <label for="mp">{{ __('price') }}</label>
        <input class="w-full rounded" type="text" wire:model="mp">
        <x-jet-input-error for="mp" />
    </div>
    <div class="col-span-3">
        <select class="w-full text-sm col-span-1 rounded" wire:model="mo">
            @foreach ($offices as $o)
                <option value="{{ $o->id }}">{{ $o->local . ',  ' . $o->address }}</option>
            @endforeach
        </select>
        <x-jet-input-error for="mo" />
    </div>
</div>
