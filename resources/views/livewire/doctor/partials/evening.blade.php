<div class="grid grid-cols-3 gap-2 text-sm items-center">
    <div>
        <label for="es">{{ __('hora de inicio') }}</label>
        <select class="w-full text-sm col-span-1" wire:model="es">
            @foreach ($evening as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-input-error for="es" />
    </div>
    <div>
        <label for="ee">{{ __('hora de finalizacion') }}</label>
        <select class="w-full text-sm col-span-1 rounded" wire:model="ee">
            @foreach ($evening as $m)
                <option value="{{ $m['id'] }}">{{ $m['str_hour_12'] }}</option>
            @endforeach
        </select>
        <x-input-error for="ee" />
    </div>


    <div class="col-span-1">
        <label for="ep">{{ __('precio') }}</label>
        <input class="w-full rounded" type="text" wire:model="ep">
        <x-input-error for="ep" />
    </div>

   {{--  <div class="col-span-3">
        <select class="w-full text-sm col-span-1 rounded" wire:model="eo">
            @foreach ($offices as $o)
                <option value="{{ $o->id }}">{{ $o->local . ',  ' . $o->address }}</option>
            @endforeach
        </select>
        <x-in put-error for="eo" />
    </div>--}}

    <div class="col-span-3">
        <label for="eo">{{ __('oficina') }}</label>
        <select class="w-full text-sm col-span-1 rounded" wire:model="eo">
            <option value="" selected>{{ __('Seleccione oficina de atención') }}</option>
            @foreach ($offices as $o)
                <option value="{{ $o->id }}">{{ $o->local . ',  ' . $o->address }}</option>
            @endforeach
        </select>
        <x-input-error for="eo" />
    </div>
</div>
