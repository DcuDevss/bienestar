<div class="px-16 py-8 shadow ">
 {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
{{-- <section class="grid grid-cols-7 gap-3 text-center my-6 bg-white p-3 items-start">
     @foreach ($workdays as $workday)
        <div class="col-span-1 bg-gray-200 p-3">
            <div class="text-gray-400 font-bold">{{ DIA[$workday->day] }}</div>
            <div><input type="checkbox" @if ($workday->active) checked @endif>
                <span class="mx-2 ">{{ __('active') }}</span>
            </div> <button class="bg-blue-500 px-2 py-1 rounded w-full text-white"
                wire:click="edit({{ $workday->day }})">{{ __('editar') }}</button>
        </div>
        <div class="col-span-2 text-sm bg-gray-200 py-3 rounded">
            <h1 class="bg-gray-400 font-semibold text-white p-1">{{ __('manana') }}</h1>
            {{ $workday->HourMS }}-{{ $workday->HourME }}
            <div>{{ $workday->MO }}</div>
            <div>{{ price($workday->morning_price) }} </div>
        </div>

        <div class="col-span-2 text-sm bg-gray-200 py-3 rounded">
            <h1 class="bg-gray-400 font-semibold text-white p-1">{{ __('tarde') }}</h1>
            {{ $workday->HourAS }}-{{ $workday->HourAE }}
            <div>{{ $workday->AO }}</div>
            <div>{{ price($workday->afternoon_price) }} </div>
        </div>

        <div class="col-span-2 text-sm bg-gray-200 py-3 rounded">
            <h1 class="bg-gray-400 font-semibold text-white p-1">{{ __('noche') }}</h1>
            {{ $workday->HourES }}-{{ $workday->HourEE }}
            <div>{{ $workday->EO }}</div>
            <div>{{ price($workday->evening_price) }} </div>
        </div>
    @endforeach --}}

    <section class="grid grid-cols-7 gap-3 text-center my-6 bg-white p-3 items-start">
      @foreach ($workdays as $workday)
    <div class="col-span-1 @if ($this->hasAssignedOffice($workday->day, 'morning','afternoon','evening')) bg-green-200 @else bg-gray-200 @endif p-3">
        <div class="text-gray-400 font-bold">{{-- DIA[$workday->day] --}}</div>
        <div><input type="checkbox" @if ($workday->active) checked @endif>
            <span class="mx-2 ">{{ __('activo') }}</span>
        </div>
        <button class="bg-blue-500 px-2 py-1 rounded w-full text-white" wire:click="edit({{ $workday->day }})">{{ __('editar') }}</button>
    </div>

    <div class="col-span-2 text-sm @if ($this->hasAssignedOffice($workday->day, 'morning')) bg-green-200 @else bg-gray-200 @endif py-3 rounded">
        <h1 class="bg-gray-400 font-semibold text-white p-1">{{ __('mañana') }}</h1>
        {{ $workday->HourMS }}-{{ $workday->HourME }}
        <div>{{ $workday->MO }}</div>
        <div>{{-- price($workday->morning_price) --}} </div>
    </div>

    <div class="col-span-2 text-sm @if ($this->hasAssignedOffice($workday->day, 'afternoon')) bg-green-200 @else bg-gray-200 @endif py-3 rounded">
        <h1 class="bg-gray-400 font-semibold text-white p-1">{{ __('tarde') }}</h1>
        {{ $workday->HourAS }}-{{ $workday->HourAE }}
        <div>{{ $workday->AO }}</div>
        <div>{{-- price($workday->afternoon_price) --}} </div>
    </div>

    <div class="col-span-2 text-sm @if ($this->hasAssignedOffice($workday->day, 'evening')) bg-green-200 @else bg-gray-200 @endif py-3 rounded">
        <h1 class="bg-gray-400 font-semibold text-white p-1">{{ __('----') }}</h1>
        {{-- $workday->HourES --}}-{{-- $workday->HourEE --}}
        <div>{{-- $workday->EO --}}</div>
        <div>{{-- price($workday->evening_price) --}} </div>
    </div> {{-- --}}
@endforeach
</section>

 {{--<section class="grid grid-cols-7 gap-3 text-center my-6 bg-white p-3 items-start">
    @foreach ($workdays as $workday)
        <div class="col-span-1 bg-gray-200 p-3">
            <div class="text-gray-400 font-bold">{{ DIA[$workday->day] }}</div>
            <div><input type="checkbox" @if ($workday->active) checked @endif>
                <span class="mx-2 ">{{ __('active') }}</span>
            </div> <button class="bg-blue-500 px-2 py-1 rounded w-full text-white"
                wire:click="edit({{ $workday->day }})">{{ __('edit') }}</button>
        </div>
        <div class="col-span-2 text-sm bg-gray-200 py-3 rounded">
            <h1 class="bg-gray-400 font-semibold text-white p-1">{{ __('morning') }}</h1>
            {{ $workday->HourMS }}-{{ $workday->HourME }}
            <div>{{ $workday->MO }}</div>
            <div>{{ price($workday->morning_price) }} </div>
        </div>

        <div class="col-span-2 text-sm bg-gray-200 py-3 rounded">
            <h1 class="bg-gray-400 font-semibold text-white p-1">{{ __('afternoon') }}</h1>
            {{ $workday->HourAS }}-{{ $workday->HourAE }}
            <div>{{ $workday->AO }}</div>
            <div>{{ price($workday->afternoon_price) }} </div>
        </div>

        <div class="col-span-2 text-sm bg-gray-200 py-3 rounded">
            <h1 class="bg-gray-400 font-semibold text-white p-1">{{ __('evening') }}</h1>
            {{ $workday->HourES }}-{{ $workday->HourEE }}
            <div>{{ $workday->EO }}</div>
            <div>{{ price($workday->evening_price) }} </div>
        </div>
    @endforeach
</section>--}}




    <x-dialog-modal wire:model="officesEmpty">
        <x-slot name="title">
            <h1 class="text-2xl text-red-500">{{ __('error') }}</h1>
        </x-slot>
        <x-slot name="content">
            <h1 class="text-xl text-red-500">
                {{ __('No tiene domicilio social, registre al menos uno para crear días hábiles.') }}
            </h1>
        </x-slot>
        <x-slot name="footer">
            <button class="bg-red-500 text-white px-4 py-2 rounded" wire:click="officesEmptyClose">
                ok
            </button>
        </x-slot>
    </x-dialog-modal>

    @include('livewire.doctor.partials.workdayEditModal')



</div>

