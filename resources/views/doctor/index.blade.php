<x-app-layout>
    <x-slot name="header">
        <div class="">
            <div class="col-span-3 md:col-span-2 lg:col-span-2 xl:col-span-2">
                <h1>@livewire('patient.patient-list')</h1>
            </div>

            {{--<!-- Otras dos columnas -->
            <div class="col-span-3 md:col-span-1 lg:col-span-1 xl:col-span-1">
                <h1>@livewire('appoinment.appoinment-list')</h1>
            </div>--}}

            {{--<div class="col-span-3 md:col-span-1 lg:col-span-1 xl:col-span-1">
                <h1>@livewire('schedulle.schedulle')</h1>
            </div>--}}
        </div>
    </x-slot>
</x-app-layout>
