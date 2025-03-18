<x-app-layout>
    <section>
        <h1 class="text-center text-2xl font-semibold text-gray-400 py-3">{{ __("Datos del paciente") }}</h1>
    </section>
    <div class="container mx-auto bg-red-200 my-5 p-5">

        <section class="px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="col-span-1 md:col-span-3">
                    <div>
                        <div class="bg-white p-3 border-t-4 border-green-400">
                            <div class="image overflow-hidden">
                                <img class="h-auto w-full mx-auto" src="https://api.lorem.space/image/face?hash=88560" />
                            </div>
                            <h1 class="text-center font-bold text-gray-900 leading-8 my-1">{{ $user->name }}</h1>
                            <h3 class="text-justify font-light text-gray-600 leading-6">
                                No hay registro
                            </h3>
                            <p class="text-sm font-extralight text-gray-500 leading-8 my-1">
                                no hay datos
                            </p>
                            <ul class="bg-gray-300 rounded p-3 text-gray-500">
                                <li class="flex items-center py-3 capitalize">
                                    <span>status</span>
                                    <span
                                        class="ml-auto bg-green-700 text-white px-2 py-1 text-sm cursor-pointer rounded">active</span>
                                </li>
                                <li class="flex items-center py-3 capitalize">
                                    <span>{{ __('member since') }}</span>
                                    <span class="ml-auto">{{ $user->created_at->format('d-m-Y') }}</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                           {{--  @livewire('patient.patient-disase', ['user' => $user->id])
                            @livewire('patient.patient-surgery', ['user' => $user->id]) --}}
                        </div>

                    </div>

                </div>
                <div class="col-span-1 md:col-span-9 bg-white rounded p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 text-gray-400">
                        <div class="flex text-sm">
                            <p class="px-4 py-2 font-semibold capitalize">{{ __('nombre') }} :</p>
                            <p class="px-4 py-2 font-semibold capitalize">{{ $user->name }}</p>
                        </div>
                        <div class="flex">
                            <div class="px-4 py-2 font-semibold capitalize">{{ __('anos') }} : </div>

                            @if ($user->birthdate)
                                @if ($user->birthdate instanceof \Carbon\Carbon)
                                    {{ $user->birthdate->diffForHumans(['parts' => 2, 'join' => true]) }}
                                @else
                                    {{ __('formato inavalido') }}
                                @endif
                            @endif

                        </div>
                        <div class="flex text-sm">
                            <p class="px-4 py-2 font-semibold capitalize">{{ __('genero') }} :</p>
                            <p class="px-4 py-2 font-semibold capitalize">{{ $user->gender }}</p>
                        </div>
                        <div class="flex text-sm">
                            <p class="px-4 py-2 font-semibold capitalize">{{ __('contacto') }} :</p>
                            <p class="px-4 py-2 font-semibold capitalize">{{ $user->phone }}</p>
                        </div>
                        <div class="flex text-sm">
                            <p class="px-4 py-2 font-semibold capitalize">{{ __('fecha de nacimiento') }} :</p>
                            @if ($user->birthdate)
                                @if ($user->birthdate instanceof \Carbon\Carbon)
                                    <p class="px-4 py-2 font-semibold capitalize">
                                        {{ $user->birthdate->format('d-m-Y') }}
                                    </p>
                                @else
                                    <p class="px-4 py-2 font-semibold capitalize">{{ __('formato invalido') }}</p>
                                @endif
                            @endif
                        </div>

                        <div class="flex text-sm">
                            <p class="px-4 py-2 font-semibold capitalize">{{ __('email') }} :</p>
                            <p class="px-4 py-2 font-semibold capitalize">{{ $user->email }}</p>
                        </div>

                        <div class="flex text-sm">
                            <p class="px-4 py-2 font-semibold capitalize">{{ __('direccion') }} :</p>
                            <p class="px-4 py-2 font-semibold capitalize">{{ $user->address }}</p>
                        </div>
                        <a href="#"
                            class="px-6 py-3 bg-gray-300 col-span-full hover:text-gray-600 text-center text-black my-12">{{ __('ver informacion ') }}</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 text-gray-400 gap-4">
                        <div class="col-span-3 md:col-span-2">
                          {{--    @livewire('patient.patient-interview', ['user' => $user->id])--}}
                        </div>

                        <div class="col-span-3 md:col-span-1">
                           {{-- @livewire('patient.patient-list-interview', ['user' => $user->id]) --}}

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
