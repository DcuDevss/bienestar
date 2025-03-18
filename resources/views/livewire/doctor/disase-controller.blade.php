<div class="py-8">
    <section class="w-full max-w-5xl mx-auto bg-gray-100 text-gray-600 h-screen px-4 py-8">
        <header class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-center text-gray-800 capitalize text-2xl mb-2">{{ __('enfermedades') }}</h2>
        </header>
        <div class="flex items-center bg-white p-3">
            <input class="w-full rounded" type="text" placeholder="search disase" wire:model.live="search"/>
            <select class="mx-2 rounded" wire:model.live="perPage">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <select class="mx-2 rounded" wire:model.live="sortAsc">
                <option value="1">{{ __('asc') }}</option>
                <option value="0">{{ __('des') }}</option>
            </select>
            <a class="text-green-500 m-auto rounded cursor-pointer" wire:click="$set('modal',true)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </a>
        </div>
        <table class="table-auto w-full bg-white p-6">
            <thead class="text-sm font-semibold uppercase text-white bg-gray-300">
                <tr>
                    <th>
                        <div class="p-4 text-left capitalize">{{ __('nombre') }}</div>
                    </th>
                    <th>
                        <div class="p-4 text-left capitalize">{{ __('sintomas') }}</div>
                    </th>
                    <th>
                        <div class="p-4 text-left capitalize">{{ __('acciones') }}</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($disases as $disase)
                    <tr>
                        <td class="p-2 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                                <div>
                                    {{ $disase->name }}
                                </div>
                            </div>

                        </td>
                        <td class="p-2" width="60%">
                            <div>
                                {{ $disase->symptoms }}
                            </div>
                        </td>
                        <td class="p-2 whitespace-nowrap" width="15%">
                            <div class="flex justify-around items-center">
                                <a class="text-green-500 cursor-pointer" wire:click="edit({{ $disase->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <a class="text-red-500 cursor-pointer" wire:click="delete({{ $disase->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
            @if ($disases->count() > 0)
       <div class="flex justify-between text-xs my-3 bg-gray-400 p-4">
           {{ $disases->links() }}
       </div>
       @endif

    </section>

    <x-dialog-modal wire:model="modal">
        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('agregar enfermedad') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/banner-skill.jpg') }}"
                alt="{{ auth()->user()->name }}">
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-1 gap-6">
                <div class="seleccionadas">
                    <div>
                        <input class="w-full rounded" type="text" placeholder="{{ __('nombre') }}"
                            wire:model="name" />
                        <x-input-error for="name" />
                    </div>
                </div>

                <div class="seleccionadas">
                    <div>
                        <textarea class="w-full rounded" type="textarea" placeholder="{{ __('sintomas') }}"
                            wire:model="symptoms"></textarea>
                        <x-input-error for="symptoms" />
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button class="bg-red-500 text-white hover:bg-red-900 px-4 py-2 rounded mx-3"
                wire:click="$set('modal',false)">
                {{ __('cancelar') }}
            </button>
            <button class="bg-green-500 text-white hover:bg-green-800 px-4 py-2 rounded" type="submit"
                wire:click="addDisase">
                {{ __('crear') }}
            </button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="modalEdit">
        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('actualizar enfermedad') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/banner-skill.jpg') }}"
                alt="{{ auth()->user()->name }}">
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-1 gap-6">
                <div class="seleccionadas">
                    <div>
                        <input class="w-full rounded" type="text" placeholder="{{ __('nombre') }}"
                            wire:model="name" />
                        <x-input-error for="name" />
                    </div>
                </div>

                <div class="seleccionadas">
                    <div>
                        <textarea class="w-full rounded" type="textarea" placeholder="{{ __('sintomas') }}"
                            wire:model="symptoms"></textarea>
                        <x-input-error for="symptoms" />
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button class="bg-red-500 text-white hover:bg-red-900 px-4 py-2 rounded mx-3"
                wire:click="$set('modalEdit',false)">
                {{ __('cancelar') }}
            </button>
            <button class="bg-green-500 text-white hover:bg-green-800 px-4 py-2 rounded" type="submit"
                wire:click="update({{ $disaseId }})">
                {{ __('actualizar') }}
            </button>
        </x-slot>
    </x-dialog-modal>

</div>


{{-- <div class="bg-slate-800 text-gray-900 tracking-wider leading-normal m-4">

    <div class="max-w mx-auto sm:px-6 lg:px-8 ">
        <section class=" bg-white text-gray-600 rounded-md px-1">
            <div class="w-full  mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                <div class="py-3">
                    <div class="overflow-x-auto">
                        <div class=" pb-3">
                            <select class="rounded-md ml-3" wire:model="perPage">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                            </select>
                            <input type="text" class="form-input text-gray-500 ml-6 rounded-md" wire:model.live="search"
                                placeholder="Ingrese la busqueda">
                            <button wire:click="clear" class="ml-2"><span class="fa fa-eraser"></span></button>

                            <a class="text-green-500 m-auto rounded cursor-pointer" wire:click="$set('modal', true)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>
                        </div>
                        <table class="w-full table-auto">
                            <thead class="text-xs font-semibold uppercase text-gray-900 bg-slate-400">
                                <tr>
                                    <th class="p-1   text-center text-xs text-red-500">
                                        Nro
                                        @if ($sort1 == 'id')
                                            @if ($direction1 == 'asc')
                                                <i class="fas fa-sort-up text-yellow-400"></i>
                                            @else
                                                <i class="fas fa-sort-down text-yellow-400"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort text-yellow-400"></i>
                                        @endif
                                    </th>
                                    <th class="p-1  text-center  text-xs text-blue-800 cursor-pointer">

                                        nombre
                                    </th>
                                    <th class="p-1   text-center text-xs text-blue-800">

                                        sintomas
                                    </th>

                                    <th class="p-1   text-center text-xs text-blue-800">
                                         Acciones

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach ($disases as $disase)
                                    <tr>
                                        <td class="text-center py-6 font-bold">{{ $disase->id }}</td>
                                        <td class="text-center py-6 font-bold">
                                            {{ $disase->name?? '----' }}</td>
                                        <td class="text-center py-6 font-bold">
                                            {{ $disase->symptoms?? '----' }}</td>

                                            <td class="p-2 whitespace-nowrap" width="15%">
                                                <div class="flex justify-around items-center">
                                                    <a class="text-green-500 cursor-pointer" wire:click="edit({{ $disase->id }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    <a class="text-red-500 cursor-pointer" wire:click="delete({{ $disase->id }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div
                            class="bg-white px-4 py-3 text-justify  items-center justify-between border-gray-200 sm:px-6 float-right">
                            {{ $disases->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <x-dialog-modal wire:model="modal">
            <x-slot name="title">
                <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                    {{ __('agregar enfermedades') }}
                </div>
                <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/banner-skill.jpg') }}"
                    alt="{{ auth()->user()->name }}">
            </x-slot>
            <x-slot name="content">
                <div class="grid grid-cols-1 gap-6">
                    <div class="seleccionadas">
                        <div>
                            <input class="w-full rounded" type="text" placeholder="{{ __('nombre') }}"
                                wire:model="name" />
                            <x-input-error for="name" />
                        </div>
                    </div>

                    <div class="seleccionadas">
                        <div>
                            <textarea class="w-full rounded" type="textarea" placeholder="{{ __('sintomas') }}"
                                wire:model="symptoms"></textarea>
                            <x-input-error for="symptoms" />
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <button class="bg-red-500 text-white hover:bg-red-900 px-4 py-2 rounded mx-3"
                    wire:click="$set('modal',false)">
                    {{ __('cancel') }}
                </button>
                <button class="bg-green-500 text-white hover:bg-green-800 px-4 py-2 rounded" type="submit"
                    wire:click="addDisase">
                    {{ __('crear') }}
                </button>
            </x-slot>
        </x-dialog-modal>

        <x-dialog-modal wire:model="modalEdit">
            <x-slot name="title">
                <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                    {{ __('editar enfermedad') }}
                </div>
                <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/banner-skill.jpg') }}"
                    alt="{{ auth()->user()->name }}">
            </x-slot>
            <x-slot name="content">
                <div class="grid grid-cols-1 gap-6">
                    <div class="seleccionadas">
                        <div>
                            <input class="w-full rounded" type="text" placeholder="{{ __('nombre') }}"
                                wire:model="name" />
                            <x-input-error for="name" />
                        </div>
                    </div>

                    <div class="seleccionadas">
                        <div>
                            <textarea class="w-full rounded" type="textarea" placeholder="{{ __('sintomas') }}"
                                wire:model="symptoms"></textarea>
                            <x-input-error for="symptoms" />
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <button class="bg-red-500 text-white hover:bg-red-900 px-4 py-2 rounded mx-3"
                    wire:click="$set('modalEdit',false)">
                    {{ __('cancelar') }}
                </button>
                <button class="bg-green-500 text-white hover:bg-green-800 px-4 py-2 rounded" type="submit"
                    wire:click="update({{ $disaseId }})">
                    {{ __('editar') }}
                </button>
            </x-slot>
        </x-dialog-modal>

    </div>
</div> --}}





{{--  <div class="py-8">
    <section class="w-full max-w-5xl mx-auto bg-gray-100 text-gray-600 h-screen px-4 py-8">
        <header class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-center text-gray-800 capitalize text-2xl mb-2">{{ __('enfermedades') }}</h2>
        </header>
        <div class="flex items-center bg-white p-3">
            <input class="w-full rounded" type="text" placeholder="{{ __('Buscar enfermedad') }}" wire:model="search" />

            <select class="mx-2 rounded" wire:model="perPage">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>

            <a class="text-green-500 m-auto rounded cursor-pointer" wire:click="$set('modal', true)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </a>
        </div>
        <table class="table-auto w-full bg-white p-6">
            <thead class="text-sm font-semibold uppercase text-white bg-gray-300">
                <tr>
                    <th>
                        <div class="p-4 text-left capitalize">{{ __('nombre') }}</div>
                    </th>
                    <th>
                        <div class="p-4 text-left capitalize">{{ __('síntomas') }}</div>
                    </th>
                    <th>
                        <div class="p-4 text-left capitalize">{{ __('acciones') }}</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($disases as $disase)
                    <tr>
                        <td class="p-2 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                                <div>
                                    {{ $disase->name }}
                                </div>
                            </div>
                        </td>
                        <td class="p-2" width="60%">
                            <div>
                                {{ $disase->symptoms }}
                            </div>
                        </td>
                        <td class="p-2 whitespace-nowrap" width="15%">
                            <div class="flex justify-around items-center">
                                <a class="text-green-500 cursor-pointer" wire:click="edit({{ $disase->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <a class="text-red-500 cursor-pointer" wire:click="delete({{ $disase->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($disases->count() > 0)
            <div class="flex justify-between text-xs my-3 bg-gray-400 p-4">
                {{ $disases->links() }}
            </div>
        @endif
    </section>

    <x-dialog-modal wire:model="modal">
        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('agregar enfermedades') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/banner-skill.jpg') }}"
                alt="{{ auth()->user()->name }}">
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-1 gap-6">
                <div class="seleccionadas">
                    <div>
                        <input class="w-full rounded" type="text" placeholder="{{ __('nombre') }}"
                            wire:model="name" />
                        <x-input-error for="name" />
                    </div>
                </div>

                <div class="seleccionadas">
                    <div>
                        <textarea class="w-full rounded" type="textarea" placeholder="{{ __('sintomas') }}"
                            wire:model="symptoms"></textarea>
                        <x-input-error for="symptoms" />
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button class="bg-red-500 text-white hover:bg-red-900 px-4 py-2 rounded mx-3"
                wire:click="$set('modal',false)">
                {{ __('cancel') }}
            </button>
            <button class="bg-green-500 text-white hover:bg-green-800 px-4 py-2 rounded" type="submit"
                wire:click="addDisase">
                {{ __('crear') }}
            </button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="modalEdit">
        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('editar enfermedad') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/banner-skill.jpg') }}"
                alt="{{ auth()->user()->name }}">
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-1 gap-6">
                <div class="seleccionadas">
                    <div>
                        <input class="w-full rounded" type="text" placeholder="{{ __('nombre') }}"
                            wire:model="name" />
                        <x-input-error for="name" />
                    </div>
                </div>

                <div class="seleccionadas">
                    <div>
                        <textarea class="w-full rounded" type="textarea" placeholder="{{ __('sintomas') }}"
                            wire:model="symptoms"></textarea>
                        <x-input-error for="symptoms" />
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button class="bg-red-500 text-white hover:bg-red-900 px-4 py-2 rounded mx-3"
                wire:click="$set('modalEdit',false)">
                {{ __('cancelar') }}
            </button>
            <button class="bg-green-500 text-white hover:bg-green-800 px-4 py-2 rounded" type="submit"
                wire:click="update({{ $disaseId }})">
                {{ __('editar') }}
            </button>
        </x-slot>
    </x-dialog-modal>
</div> --}}





