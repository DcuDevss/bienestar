<div class="grid grid-cols-3 gap-2 text-sm items-center">
    <div>
        <label for="as">{{ __('hora de inicio') }}</label>
        <select class="w-full text-sm col-span-1" wire:model="as">
            @foreach ($afternoon as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-input-error for="as" />
    </div>
    <div>
        <label for="ae">{{ __('hora de finalizacion') }}</label>
        <select class="w-full text-sm col-span-1 rounded" wire:model="ae">
            @foreach ($afternoon as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-input-error for="ae" />
    </div>

    {{-- <div class="col-span-1">
        <label for="ap">{{ __('precio') }}</label>
        <input class="w-full rounded" type="text" wire:model="ap">
        <x-input-error for="ap" />
    </div> --}}

   {{-- <div class="col-span-3">
        <select class="w-full text-sm col-span-1 rounded" wire:model="ao">
            @foreach ($offices as $o)
                <option value="{{ $o->id }}">{{ $o->local . ',  ' . $o->address }}</option>
            @endforeach
        </select>
        <x-input-error for="ao" />
    </div> --}}

    <div class="col-span-3">
        <label for="ao">{{ __('oficina') }}</label>
        <select class="w-full text-sm col-span-1 rounded" wire:model="ao">
            <option value="" selected>{{ __('Seleccione oficina de atención') }}</option>
            @foreach ($offices as $o)
                <option value="{{ $o->id }}">{{ $o->local . ',  ' . $o->address }}</option>
            @endforeach
        </select>
        <x-input-error for="ao" />
    </div>


</div>
