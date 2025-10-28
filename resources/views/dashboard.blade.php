<x-app-layout>
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight"> okis
            {{ __('Dashboard') }}
        </h2> -->
    </x-slot>

    <div class="py-6">
        <div class=" mx-auto">
            <div class="">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xl:col-span-2">
                    <h1>@livewire('patient.patient-list')</h1>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>