<div class="grid grid-cols-3 gap-2 text-sm items-center">
    <div>
        <label for="ms">{{ __('hora de inicio') }}</label>
        <select class="w-full text-sm col-span-1" wire:model="ms">
            @foreach ($morning as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-input-error for="ms" />
    </div>
    <div>
        <label for="me">{{ __('hora de finalizacion') }}</label>
        <select class="w-full text-sm col-span-1 rounded" wire:model="me">
            @foreach ($morning as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-input-error for="me" />
    </div>

    {{-- <div class="col-span-1">
        <label for="mp">{{ __('precio') }}</label>
        <input class="w-full rounded" type="text" wire:model="mp">
        <x-input-error for="mp" />
    </div> --}}

    <div class="col-span-3">
        <label for="mo">{{ __('oficina') }}</label>
        <select class="w-full text-sm col-span-1 rounded" wire:model="mo">
            <option value="" selected>{{ __('Seleccione oficina de atención') }}</option>
            @foreach ($offices as $o)
                <option value="{{ $o->id }}">{{ $o->local . ',  ' . $o->address }}</option>
            @endforeach
        </select>
        <x-input-error for="mo" />
    </div>
</div>
