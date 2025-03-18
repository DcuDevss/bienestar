<div class="grid grid-cols-3 gap-2 text-sm items-center">
    <div>
        <label for="as">{{ __('start') }}</label>
        <select class="w-full text-sm col-span-1" wire:model="as">
            @foreach ($afternoon as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-jet-input-error for="as" />
    </div>
    <div>
        <label for="ae">{{ __('end') }}</label>
        <select class="w-full text-sm col-span-1 rounded" wire:model="ae">
            @foreach ($afternoon as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-jet-input-error for="ae" />
    </div>


    <div class="col-span-1">
        <label for="ap">{{ __('price') }}</label>
        <input class="w-full rounded" type="text" wire:model="ap">
        <x-jet-input-error for="ap" />
    </div>
    <div class="col-span-3">
        <select class="w-full text-sm col-span-1 rounded" wire:model="ao">
            @foreach ($offices as $o)
                <option value="{{ $o->id }}">{{ $o->local . ',  ' . $o->address }}</option>
            @endforeach
        </select>
        <x-jet-input-error for="ao" />
    </div>
</div>
