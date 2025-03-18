<div class="grid grid-cols-3 gap-2 text-sm items-center">
    <div>
        <label for="es">{{ __('start') }}</label>
        <select class="w-full text-sm col-span-1" wire:model="es">
            @foreach ($evening as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-jet-input-error for="es" />
    </div>
    <div>
        <label for="ee">{{ __('end') }}</label>
        <select class="w-full text-sm col-span-1 rounded" wire:model="ee">
            @foreach ($evening as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-jet-input-error for="ee" />
    </div>


    <div class="col-span-1">
        <label for="ep">{{ __('price') }}</label>
        <input class="w-full rounded" type="text" wire:model="ep">
        <x-jet-input-error for="ep" />
    </div>
    <div class="col-span-3">
        <select class="w-full text-sm col-span-1 rounded" wire:model="eo">
            @foreach ($offices as $o)
                <option value="{{ $o->id }}">{{ $o->local . ',  ' . $o->address }}</option>
            @endforeach
        </select>
        <x-jet-input-error for="eo" />
    </div>
</div>
